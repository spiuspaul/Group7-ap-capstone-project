<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Equipment;
use App\Domain\Exceptions\EquipmentException;

class EquipmentTest extends TestCase
{
    public function testRequiredFields(): void
    {
        $this->expectException(EquipmentException::class);
        $this->expectExceptionMessage("Equipment.FacilityId, Equipment.Name, and Equipment.InventoryCode are required.");

        new Equipment(
            equipmentId: null,
            facilityId: 0,
            name: '',
            inventoryCode: '',
        );
    }

    public function testUsageDomainSupportPhaseCoherenceFails(): void
    {
        $this->expectException(EquipmentException::class);
        $this->expectExceptionMessage("Electronics equipment must support Prototyping or Testing.");

        new Equipment(
            equipmentId: null,
            facilityId: 1,
            name: 'Oscilloscope',
            inventoryCode: 'EQ-001',
            usageDomain: 'Electronics',
            supportPhase: 'Training'
        );
    }

    public function testValidEquipmentCreation(): void
    {
        $equipment = new Equipment(
            equipmentId: null,
            facilityId: 1,
            name: '3D Printer',
            inventoryCode: 'EQ-002',
            usageDomain: 'Electronics',
            supportPhase: 'Prototyping'
        );

        $this->assertEquals('3D Printer', $equipment->getName());
        $this->assertEquals('EQ-002', $equipment->getInventoryCode());
        $this->assertEquals('Electronics', $equipment->getUsageDomain());
        $this->assertEquals('Prototyping', $equipment->getSupportPhase());
    }
}
