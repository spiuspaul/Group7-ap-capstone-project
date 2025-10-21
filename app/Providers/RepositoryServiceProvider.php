<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\ProgramRepository;
use App\Domain\Repositories\FacilityRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\FacilityRepository;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\EquipmentRepository;
use App\Domain\Repositories\ServiceRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\ServiceRepository;
use App\Domain\Repositories\ParticipantRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\ParticipantRepository;
use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\ProjectRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProgramRepositoryInterface::class,
            ProgramRepository::class
        );

        // Facility Repository
        $this->app->bind(
            FacilityRepositoryInterface::class,
            FacilityRepository::class
        );

        // Equipment Repository
        $this->app->bind(
            EquipmentRepositoryInterface::class,
            EquipmentRepository::class
        );

        // Service Repository
        $this->app->bind(
            ServiceRepositoryInterface::class,
            ServiceRepository::class
        );

        // Participant Repository
        $this->app->bind(
            ParticipantRepositoryInterface::class,
            ParticipantRepository::class
        );
        
        // Project Repository
        $this->app->bind(
            ProjectRepositoryInterface::class,
            ProjectRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}