<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\UseCases\Equipment\CreateEquipmentUseCase;
use App\Application\UseCases\Equipment\UpdateEquipmentUseCase;
use App\Application\UseCases\Equipment\DeleteEquipmentUseCase;
use App\Application\DTOs\EquipmentDTO;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Domain\Entities\Equipment;
use App\Domain\Exceptions\EquipmentException;

class EquipmentUseCasesTest extends TestCase
{
    public function testCreatesEquipmentSuccessfully(): void
    {
        // Arrange
        $repo = $this->createMock(EquipmentRepositoryInterface::class);
        $repo->method('findByInventoryCode')->willReturn(null);
        // save should return the domain entity (simulate repository returning saved entity)
        $repo->method('save')->willReturnCallback(function (Equipment $e) {
            return new Equipment(
                equipmentId: 1,
                facilityId: $e->getFacilityId(),
                name: $e->getName(),
                inventoryCode: $e->getInventoryCode(),
                capabilities: $e->getCapabilities(),
                description: $e->getDescription(),
                usageDomain: $e->getUsageDomain(),
                supportPhase: $e->getSupportPhase()
            );
        });

        $useCase = new CreateEquipmentUseCase($repo);

        $dto = new EquipmentDTO(
            facilityId: 1,
            name: 'Microscope',
            inventoryCode: 'EQ-100',
            capabilities: null,
            description: 'Optical microscope',
            usageDomain: 'Optics',
            supportPhase: null
        );

        // Act
        $equipment = $useCase->execute($dto);

        // Assert
        $this->assertInstanceOf(Equipment::class, $equipment);
        $this->assertEquals(1, $equipment->getEquipmentId());
        $this->assertEquals('Microscope', $equipment->getName());
        $this->assertEquals('EQ-100', $equipment->getInventoryCode());
    }

    public function testPreventsDuplicateInventoryCodeOnCreate(): void
    {
        // Arrange
        $existing = new Equipment(
            equipmentId: 2,
            facilityId: 1,
            name: 'Existing',
            inventoryCode: 'EQ-200'
        );

        $repo = $this->createMock(EquipmentRepositoryInterface::class);
        $repo->method('findByInventoryCode')->with('EQ-200')->willReturn($existing);

        $useCase = new CreateEquipmentUseCase($repo);

        $dto = new EquipmentDTO(
            facilityId: 1,
            name: 'New',
            inventoryCode: 'EQ-200'
        );

        // Assert
        $this->expectException(EquipmentException::class);
        $this->expectExceptionMessage('Equipment.InventoryCode already exists.');

        // Act
        $useCase->execute($dto);
    }

    public function testUpdatesEquipmentSuccessfully(): void
    {
        // Arrange
        $existing = new Equipment(
            equipmentId: 3,
            facilityId: 1,
            name: 'Old Name',
            inventoryCode: 'EQ-300'
        );

        $repo = $this->createMock(EquipmentRepositoryInterface::class);
        // findByInventoryCode returns null (no conflict) for the new code
        $repo->method('findByInventoryCode')->willReturn(null);
        // update should return the updated entity (simulate)
        $repo->method('update')->willReturnCallback(function (Equipment $e) {
            return new Equipment(
                equipmentId: $e->getEquipmentId(),
                facilityId: $e->getFacilityId(),
                name: $e->getName(),
                inventoryCode: $e->getInventoryCode(),
                capabilities: $e->getCapabilities(),
                description: $e->getDescription(),
                usageDomain: $e->getUsageDomain(),
                supportPhase: $e->getSupportPhase()
            );
        });
        // findById may be used by implementation; if so, return existing
        $repo->method('findById')->with(3)->willReturn($existing);

        $useCase = new UpdateEquipmentUseCase($repo);

        $dto = new EquipmentDTO(
            facilityId: 1,
            name: 'New Name',
            inventoryCode: 'EQ-300',
            capabilities: null,
            description: 'Updated',
            usageDomain: null,
            supportPhase: null
        );

        // Act
        $updated = $useCase->execute(3, $dto);

        // Assert
        $this->assertEquals(3, $updated->getEquipmentId());
        $this->assertEquals('New Name', $updated->getName());
        $this->assertEquals('EQ-300', $updated->getInventoryCode());
        $this->assertEquals('Updated', $updated->getDescription());
    }

    public function testUpdateThrowsWhenRepositorySignalsNotFound(): void
    {
        // Arrange
        $repo = $this->createMock(EquipmentRepositoryInterface::class);
        // findByInventoryCode returns null (no uniqueness conflict)
        $repo->method('findByInventoryCode')->willReturn(null);
        // configure update to throw when repository cannot find the equipment
        $repo->method('update')->will($this->throwException(new EquipmentException('Equipment not found.')));

        $useCase = new UpdateEquipmentUseCase($repo);

        $dto = new EquipmentDTO(
            facilityId: 1,
            name: 'Missing',
            inventoryCode: 'EQ-999'
        );

        $this->expectException(EquipmentException::class);
        $this->expectExceptionMessage('Equipment not found.');

        // Act
        $useCase->execute(999, $dto);
    }

    public function testDeletesEquipmentSuccessfully(): void
    {
        // Arrange
        $repo = $this->createMock(EquipmentRepositoryInterface::class);
        // delete returns true
        $repo->method('isReferencedByActiveProject')->with(5)->willReturn(false);
        $repo->method('delete')->with(5)->willReturn(true);

        $useCase = new DeleteEquipmentUseCase($repo);

        // Act
        $result = $useCase->execute(5);

        // Assert
        $this->assertTrue($result);
    }

    public function testDeleteFailsWhenReferencedByActiveProject(): void
    {
        // Arrange
        $repo = $this->createMock(EquipmentRepositoryInterface::class);
        $repo->method('isReferencedByActiveProject')->with(7)->willReturn(true);

        $useCase = new DeleteEquipmentUseCase($repo);

        $this->expectException(EquipmentException::class);
        $this->expectExceptionMessage('Equipment referenced by active Project.');

        // Act
        $useCase->execute(7);
    }

    public function testDeleteReturnsFalseIfRepositoryReturnsFalse(): void
    {
        // Arrange
        $repo = $this->createMock(EquipmentRepositoryInterface::class);
        $repo->method('isReferencedByActiveProject')->with(8)->willReturn(false);
        $repo->method('delete')->with(8)->willReturn(false);

        $useCase = new DeleteEquipmentUseCase($repo);

        // Act
        $result = $useCase->execute(8);

        // Assert
        $this->assertFalse($result);
    }
}
