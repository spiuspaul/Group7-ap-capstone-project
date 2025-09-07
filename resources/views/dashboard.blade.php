@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-primary text-white rounded-3 p-5 text-center">
                <h1 class="display-4 fw-bold mb-3">AP Capstone Dashboard</h1>
                <p class="lead mb-0">Manage your programs, facilities, projects, and more</p>
            </div>
        </div>
    </div>

    

    <!-- Navigation Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4 fw-bold mb-4 text-dark">Quick Access</h2>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('programs.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-collection text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 text-dark">Programs</h5>
                            <p class="card-text text-muted small mb-0">Manage academic programs and curricula</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{ route('facilities.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-building text-success" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 text-dark">Facilities</h5>
                            <p class="card-text text-muted small mb-0">Oversee campus facilities and resources</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{ route('projects.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-diagram-3 text-info" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 text-dark">Projects</h5>
                            <p class="card-text text-muted small mb-0">Track and manage ongoing projects</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{ route('equipments.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-tools text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 text-dark">Equipment</h5>
                            <p class="card-text text-muted small mb-0">Manage inventory and equipment</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{ route('services.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-gear text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 text-dark">Services</h5>
                            <p class="card-text text-muted small mb-0">Configure and manage services</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{ route('participants.index') }}" class="card border-0 shadow-sm h-100 text-decoration-none card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-people text-secondary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 text-dark">Participants</h5>
                            <p class="card-text text-muted small mb-0">Manage students and participants</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Custom CSS for hover effects -->
    <style>
        .square-card {
            aspect-ratio: 1;
            min-height: 250px;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        
        .card-hover:hover .card-title {
            color: var(--bs-primary) !important;
        }
    </style>
@endsection