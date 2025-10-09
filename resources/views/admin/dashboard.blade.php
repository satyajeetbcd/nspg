@extends('admin.layouts.app')

@section('title', 'Admin Dashboard - NSPG')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="page-title">Dashboard</h1>
        <p class="text-muted">Welcome to NSPG Admin Panel</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="stats-number">{{ $stats['banners'] }}</div>
            <div class="stats-label">Total Banners</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="stats-number">{{ $stats['active_banners'] }}</div>
            <div class="stats-label">Active Banners</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="stats-number">{{ $stats['solar_systems'] }}</div>
            <div class="stats-label">Solar Systems</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="stats-number">{{ $stats['page_contents'] }}</div>
            <div class="stats-label">Page Contents</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Banners -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-images me-2"></i>
                    Recent Banners
                </h5>
            </div>
            <div class="card-body">
                @if($recent_banners->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_banners as $banner)
                                <tr>
                                    <td>{{ Str::limit($banner->title, 30) }}</td>
                                    <td>
                                        <span class="badge {{ $banner->is_active ? 'badge-success' : 'badge-danger' }}">
                                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $banner->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-primary">View All Banners</a>
                    </div>
                @else
                    <p class="text-muted text-center">No banners found.</p>
                    <div class="text-center">
                        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Create First Banner</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Solar Systems -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-solar-panel me-2"></i>
                    Recent Solar Systems
                </h5>
            </div>
            <div class="card-body">
                @if($recent_solar_systems->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Capacity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_solar_systems as $system)
                                <tr>
                                    <td>{{ Str::limit($system->name, 20) }}</td>
                                    <td>{{ $system->capacity }}</td>
                                    <td>
                                        <span class="badge {{ $system->is_active ? 'badge-success' : 'badge-danger' }}">
                                            {{ $system->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.solar-systems.edit', $system) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.solar-systems.index') }}" class="btn btn-primary">View All Systems</a>
                    </div>
                @else
                    <p class="text-muted text-center">No solar systems found.</p>
                    <div class="text-center">
                        <a href="{{ route('admin.solar-systems.create') }}" class="btn btn-primary">Create First System</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.banners.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Add New Banner
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.solar-systems.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Add Solar System
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.page-contents.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Add Page Content
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-success w-100" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            View Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
