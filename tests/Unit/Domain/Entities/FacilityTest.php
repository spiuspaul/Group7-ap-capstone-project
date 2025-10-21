<?php

namespace Tests\Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Domain\Entities\Facility;
use App\Domain\Exceptions\FacilityException;

class FacilityTest extends TestCase
{
    #[Test]
    public function it_creates_a_facility_successfully()
    {
        $facility = new Facility(
            id: 1,
            name: "Tech Institute",
            location: "Kampala",
            facilityType: "Education",
            description: "Training hub for ICT",
            partnerOrganization: "NITA-U",
            capabilities: ["Training", "Research"]
        );

        $this->assertEquals(1, $facility->getId());
        $this->assertEquals("Tech Institute", $facility->getName());
        $this->assertEquals("Kampala", $facility->getLocation());
        $this->assertEquals("Education", $facility->getFacilityType());
        $this->assertEquals("Training hub for ICT", $facility->getDescription());
        $this->assertEquals("NITA-U", $facility->getPartnerOrganization());
        $this->assertEquals(["Training", "Research"], $facility->getCapabilities());
    }

    #[Test]
    public function it_throws_exception_when_name_is_missing()
    {
        $this->expectException(FacilityException::class);
        $this->expectExceptionMessage("Facility.Name is required.");

        new Facility(
            id: null,
            name: "  ",
            location: "Kampala",
            facilityType: "Education"
        );
    }

    #[Test]
    public function it_throws_exception_when_location_is_missing()
    {
        $this->expectException(FacilityException::class);
        $this->expectExceptionMessage("Facility.Location is required.");

        new Facility(
            id: null,
            name: "Tech Hub",
            location: "",
            facilityType: "Innovation"
        );
    }

    #[Test]
    public function it_throws_exception_when_facility_type_is_missing()
    {
        $this->expectException(FacilityException::class);
        $this->expectExceptionMessage("Facility.FacilityType is required.");

        new Facility(
            id: null,
            name: "Tech Hub",
            location: "Kampala",
            facilityType: ""
        );
    }

    // /** @test */
    // public function it_trims_whitespace_and_still_validates_properly()
    // {
    //     $facility = new Facility(
    //         id: null,
    //         name: "  Makerere Research Center  ",
    //         location: "  Kampala  ",
    //         facilityType: "  University  "
    //     );

    //     $this->assertEquals("  Makerere Research Center  ", $facility->getName());
    //     $this->assertEquals("  Kampala  ", $facility->getLocation());
    //     $this->assertEquals("  University  ", $facility->getFacilityType());
    // }
}
