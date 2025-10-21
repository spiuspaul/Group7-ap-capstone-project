<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Facility;
use App\Domain\Exceptions\FacilityException;
use App\Domain\Repositories\FacilityRepositoryInterface;
use App\Application\DTOs\FacilityDTO;
use App\Application\UseCases\Facility\CreateFacilityUseCase;
use App\Application\UseCases\Facility\UpdateFacilityUseCase;
use App\Application\UseCases\Facility\DeleteFacilityUseCase;

class FacilityUseCasesTest extends TestCase
{
    /* -----------------------------------------------------------------------
       CREATE FACILITY TESTS
    ----------------------------------------------------------------------- */

    public function test_it_creates_a_facility_successfully(): void
    {
        $repo = $this->createMock(FacilityRepositoryInterface::class);
        $repo->method('findByNameAndLocation')->willReturn(null);
        $repo->method('save')->willReturnCallback(fn(Facility $facility) => $facility);

        $useCase = new CreateFacilityUseCase($repo);

        $dto = new FacilityDTO(
            name: 'Tech Hub',
            location: 'Kampala',
            facilityType: 'Innovation Center',
            description: 'A space for tech projects',
            partnerOrganization: 'Innovate Uganda',
            capabilities: ['AI Lab', 'IoT Workshop']
        );

        $facility = $useCase->execute($dto);

        $this->assertInstanceOf(Facility::class, $facility);
        $this->assertEquals('Tech Hub', $facility->getName());
        $this->assertEquals('Kampala', $facility->getLocation());
    }

    public function test_it_prevents_duplicate_facilities_by_name_and_location(): void
    {
        $repo = $this->createMock(FacilityRepositoryInterface::class);
        $repo->method('findByNameAndLocation')->willReturn(new Facility(
            id: 1,
            name: 'Tech Hub',
            location: 'Kampala',
            facilityType: 'Innovation Center'
        ));

        $useCase = new CreateFacilityUseCase($repo);

        $dto = new FacilityDTO(
            name: 'Tech Hub',
            location: 'Kampala',
            facilityType: 'Innovation Center'
        );

        $this->expectException(FacilityException::class);
        $this->expectExceptionMessage("A facility with this name already exists at this location.");

        $useCase->execute($dto);
    }

    /* -----------------------------------------------------------------------
       UPDATE FACILITY TESTS
    ----------------------------------------------------------------------- */

    public function test_it_updates_a_facility_successfully(): void
    {
        $repo = $this->createMock(FacilityRepositoryInterface::class);
        $repo->method('findByNameAndLocation')->willReturn(null);
        $repo->method('hasServices')->willReturn(false);
        $repo->method('hasEquipment')->willReturn(false);
        $repo->method('save')->willReturnCallback(fn(Facility $facility) => $facility);

        $useCase = new UpdateFacilityUseCase($repo);

        $dto = new FacilityDTO(
            name: 'Updated Hub',
            location: 'Entebbe',
            facilityType: 'Innovation Center',
            capabilities: ['Prototyping']
        );

        $facility = $useCase->execute(1, $dto);

        $this->assertEquals('Updated Hub', $facility->getName());
        $this->assertEquals('Entebbe', $facility->getLocation());
    }

    public function test_it_throws_exception_when_updating_with_duplicate_name_and_location(): void
    {
        $repo = $this->createMock(FacilityRepositoryInterface::class);
        $repo->method('findByNameAndLocation')->willReturn(new Facility(
            id: 2,
            name: 'Duplicate Hub',
            location: 'Gulu',
            facilityType: 'Lab'
        ));

        $useCase = new UpdateFacilityUseCase($repo);

        $dto = new FacilityDTO(
            name: 'Duplicate Hub',
            location: 'Gulu',
            facilityType: 'Lab'
        );

        $this->expectException(FacilityException::class);
        $this->expectExceptionMessage("A facility with this name already exists at this location.");

        $useCase->execute(1, $dto);
    }

    public function test_it_throws_exception_when_missing_capabilities_but_has_services_or_equipment(): void
    {
        $repo = $this->createMock(FacilityRepositoryInterface::class);
        $repo->method('findByNameAndLocation')->willReturn(null);
        $repo->method('hasServices')->willReturn(true);
        $repo->method('hasEquipment')->willReturn(true);

        $useCase = new UpdateFacilityUseCase($repo);

        $dto = new FacilityDTO(
            name: 'Maker Hub',
            location: 'Mbale',
            facilityType: 'Workshop',
            capabilities: [] // empty
        );

        $this->expectException(FacilityException::class);
        $this->expectExceptionMessage("Facility.Capabilities must be populated when Services/Equipment exist.");

        $useCase->execute(1, $dto);
    }

    /* -----------------------------------------------------------------------
       DELETE FACILITY TESTS
    ----------------------------------------------------------------------- */

    public function test_it_deletes_facility_successfully(): void
    {
        $repo = $this->createMock(FacilityRepositoryInterface::class);
        $repo->method('hasServices')->willReturn(false);
        $repo->method('hasEquipment')->willReturn(false);
        $repo->method('hasProjects')->willReturn(false);
        $repo->method('delete')->willReturn(true);

        $useCase = new DeleteFacilityUseCase($repo);

        $result = $useCase->execute(1);

        $this->assertTrue($result);
    }

    public function test_it_prevents_deletion_when_facility_has_dependencies(): void
    {
        $repo = $this->createMock(FacilityRepositoryInterface::class);
        $repo->method('hasServices')->willReturn(true);
        $repo->method('hasEquipment')->willReturn(false);
        $repo->method('hasProjects')->willReturn(false);

        $useCase = new DeleteFacilityUseCase($repo);

        $this->expectException(FacilityException::class);
        $this->expectExceptionMessage("Facility has dependent records (Services/Equipment/Projects).");

        $useCase->execute(1);
    }
}
