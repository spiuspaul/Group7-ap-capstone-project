<?php

namespace App\Application\DTOs;

class EquipmentDTO
{
    public function __construct(
    public readonly int $facilityId,
    public readonly string $name,
    public readonly string $inventoryCode,
    public readonly ?string $capabilities = null,
    public readonly ?string $description = null,
    public readonly ?string $usageDomain = null,
    public readonly ?string $supportPhase = null
) {}


public static function fromRequest(array $data): self
{
    return new self(
        facilityId: $data['facility_id'],
        name: $data['name'],
        inventoryCode: $data['inventory_code'],
        capabilities: $data['capabilities'] ?? null,
        description: $data['description'] ?? null,
        usageDomain: $data['usage_domain'] ?? null,
        supportPhase: $data['support_phase'] ?? null
    );
}
}