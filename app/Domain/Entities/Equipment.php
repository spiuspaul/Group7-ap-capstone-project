<?php


namespace App\Domain\Entities;


use App\Domain\Exceptions\EquipmentException;


class Equipment
{
public function __construct(
private ?int $equipmentId,
private int $facilityId,
private string $name,
private string $inventoryCode,
private ?string $capabilities = null,
private ?string $description = null,
private ?string $usageDomain = null,
private ?string $supportPhase = null
) {
$this->validate();
}


private function validate(): void
{
// Business Rule: Required Fields
if (!$this->facilityId || empty(trim($this->name)) || empty(trim($this->inventoryCode))) {
throw new EquipmentException("Equipment.FacilityId, Equipment.Name, and Equipment.InventoryCode are required.");
}


// Business Rule: UsageDomain–SupportPhase Coherence
if ($this->usageDomain === 'Electronics' && $this->supportPhase && !preg_match('/Prototyping|Testing/', $this->supportPhase)) {
throw new EquipmentException("Electronics equipment must support Prototyping or Testing.");
}
}


// Getters
public function getEquipmentId(): ?int { return $this->equipmentId; }
public function getFacilityId(): int { return $this->facilityId; }
public function getName(): string { return $this->name; }
public function getInventoryCode(): string { return $this->inventoryCode; }
public function getCapabilities(): ?string { return $this->capabilities; }
public function getDescription(): ?string { return $this->description; }
public function getUsageDomain(): ?string { return $this->usageDomain; }
public function getSupportPhase(): ?string { return $this->supportPhase; }
}