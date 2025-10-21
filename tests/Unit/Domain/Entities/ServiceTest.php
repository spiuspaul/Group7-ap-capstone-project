<?php

namespace Tests\Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Domain\Entities\Service;
use App\Domain\Exceptions\ServiceException;

class ServiceTest extends TestCase
{
    #[Test]
    public function it_throws_exception_when_required_fields_are_missing(): void
    {
        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage(
            "Service.FacilityId, Service.Name, Service.Category, and Service.SkillType are required."
        );

        new Service(
            serviceId: null,
            facilityId: 0,   // missing
            name: '',        // missing
            category: '',    // missing
            skillType: ''    // missing
        );
    }

    #[Test]
    public function it_creates_service_successfully(): void
    {
        $service = new Service(
            serviceId: null,
            facilityId: 1,
            name: 'Networking',
            category: 'IT',
            skillType: 'Technical',
            description: 'Network installation and maintenance'
        );

        $this->assertEquals(1, $service->getFacilityId());
        $this->assertEquals('Networking', $service->getName());
        $this->assertEquals('IT', $service->getCategory());
        $this->assertEquals('Technical', $service->getSkillType());
        $this->assertEquals('Network installation and maintenance', $service->getDescription());
    }

    #[Test]
    public function it_allows_nullable_description(): void
    {
        $service = new Service(
            serviceId: null,
            facilityId: 2,
            name: 'Software Support',
            category: 'IT',
            skillType: 'Technical',
            description: null
        );

        $this->assertNull($service->getDescription());
    }
}
