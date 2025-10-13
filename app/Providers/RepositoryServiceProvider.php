<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\ProgramRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProgramRepositoryInterface::class,
            ProgramRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}