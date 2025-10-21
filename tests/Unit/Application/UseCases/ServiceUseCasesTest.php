<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Application\UseCases\Service\CreateServiceUseCase;
use App\Application\UseCases\Service\UpdateServiceUseCase;
use App\Application\UseCases\Service\DeleteServiceUseCase;
use App\Application\DTOs\ServiceDTO;
use App\Domain\Entities\Service;
use App\Domain\Repositories\ServiceRepositoryInterface;
use App\Domain\Exceptions\ServiceException;

class ServiceUseCasesTest extends TestCase
{
    #[Test]
    public function it_creates_service_successfully()
    {
        $repository = $this->createMock(ServiceRepositoryInterface::class);
        $repository->method('findByNameAndFacility')->willReturn(null);
        $repository->method('save')->willReturnCallback(fn(Service $service) => $service);

        $useCase = new CreateServiceUseCase($repository);

        $dto = new ServiceDTO(
            facilityId: 1,
            name: 'Networking',
            category: 'IT',
            skillType: 'Technical',
            description: 'Network installation'
        );

        $service = $useCase->execute($dto);

        $this->assertEquals('Networking', $service->getName());
        $this->assertEquals('IT', $service->getCategory());
        $this->assertEquals('Technical', $service->getSkillType());
    }

    #[Test]
    public function it_prevents_duplicate_service_names_within_same_facility()
    {
        $existingService = new Service(
            serviceId: 1,
            facilityId: 1,
            name: 'Networking',
            category: 'IT',
            skillType: 'Technical'
        );

        $repository = $this->createMock(ServiceRepositoryInterface::class);
        $repository->method('findByNameAndFacility')->willReturn($existingService);

        $useCase = new CreateServiceUseCase($repository);

        $dto = new ServiceDTO(
            facilityId: 1,
            name: 'Networking',
            category: 'IT',
            skillType: 'Technical'
        );

        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('A service with this name already exists in this facility.');

        $useCase->execute($dto);
    }

    #[Test]
    public function it_updates_service_successfully()
    {
        $service = new Service(
            serviceId: 1,
            facilityId: 1,
            name: 'Networking',
            category: 'IT',
            skillType: 'Technical'
        );

        $repository = $this->createMock(ServiceRepositoryInterface::class);
        $repository->method('findByNameAndFacility')->willReturn(null);
        $repository->method('save')->willReturnCallback(fn(Service $s) => $s);

        $useCase = new UpdateServiceUseCase($repository);

        $dto = new ServiceDTO(
            facilityId: 1,
            name: 'Networking Advanced',
            category: 'IT',
            skillType: 'Technical'
        );

        $updated = $useCase->execute(1, $dto);

        $this->assertEquals('Networking Advanced', $updated->getName());
    }

    #[Test]
    public function it_prevents_deleting_service_if_referenced()
    {
        $repository = $this->createMock(ServiceRepositoryInterface::class);
        $repository->method('isReferencedByProjectCategory')->willReturn(true);

        $useCase = new DeleteServiceUseCase($repository);

        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('Service in use by Project testing requirements.');

        $useCase->execute(1);
    }

    #[Test]
    public function it_deletes_service_successfully_if_not_referenced()
    {
        $repository = $this->createMock(ServiceRepositoryInterface::class);
        $repository->method('isReferencedByProjectCategory')->willReturn(false);
        $repository->method('delete')->willReturn(true);

        $useCase = new DeleteServiceUseCase($repository);

        $result = $useCase->execute(1);

        $this->assertTrue($result);
    }
}
