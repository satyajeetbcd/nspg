@extends('admin.layouts.app')

@section('title', 'View Project - NSPG')
@section('page-title', 'View Project')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">Project Details</h1>
            <div>
                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit me-2"></i>
                    Edit Project
                </a>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Projects
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-solar-panel me-2"></i>
                    Project Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Project Title</h6>
                        <p class="text-muted">{{ $project->title }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Project Type</h6>
                        <p><span class="badge bg-info">{{ $project->project_type_label }}</span></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6>Location</h6>
                        <p class="text-muted">{{ $project->location }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Capacity</h6>
                        <p class="text-muted">{{ $project->capacity ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6>Project Cost</h6>
                        <p class="text-muted">{{ $project->formatted_cost }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Installation Date</h6>
                        <p class="text-muted">{{ $project->formatted_installation_date }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6>Status</h6>
                        <p>
                            <span class="badge {{ $project->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $project->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Featured</h6>
                        <p>
                            <span class="badge {{ $project->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                {{ $project->is_featured ? 'Featured' : 'Not Featured' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6>Sort Order</h6>
                        <p class="text-muted">{{ $project->sort_order }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Created At</h6>
                        <p class="text-muted">{{ $project->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                @if($project->description)
                    <div class="mt-3">
                        <h6>Description</h6>
                        <p class="text-muted">{{ $project->description }}</p>
                    </div>
                @endif

                @if($project->features && count($project->features) > 0)
                    <div class="mt-3">
                        <h6>Project Features</h6>
                        <ul class="list-unstyled">
                            @foreach($project->features as $feature)
                                <li class="mb-1">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-image me-2"></i>
                    Project Image
                </h5>
            </div>
            <div class="card-body text-center">
                @if($project->image_path)
                    <img src="{{ asset('/' . $project->image_path) }}" 
                         alt="{{ $project->image_alt }}" 
                         class="img-fluid rounded" 
                         style="max-height: 300px;">
                    @if($project->image_alt)
                        <p class="text-muted small mt-2">{{ $project->image_alt }}</p>
                    @endif
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" 
                         style="height: 200px;">
                        <div class="text-center">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="text-muted">No image uploaded</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn {{ $project->is_active ? 'btn-warning' : 'btn-success' }} toggle-status"
                            data-id="{{ $project->id }}"
                            data-status="{{ $project->is_active ? 'active' : 'inactive' }}">
                        <i class="fas fa-power-off me-2"></i>
                        {{ $project->is_active ? 'Deactivate' : 'Activate' }} Project
                    </button>
                    
                    <button class="btn {{ $project->is_featured ? 'btn-outline-warning' : 'btn-warning' }} toggle-featured"
                            data-id="{{ $project->id }}"
                            data-featured="{{ $project->is_featured ? 'featured' : 'not-featured' }}">
                        <i class="fas fa-star me-2"></i>
                        {{ $project->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                    </button>
                    
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Project
                    </a>
                    
                    <button type="button" class="btn btn-danger delete-project" 
                            data-id="{{ $project->id }}"
                            data-title="{{ $project->title }}">
                        <i class="fas fa-trash me-2"></i>
                        Delete Project
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this project?</p>
                <p><strong id="project-title"></strong></p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="delete-form" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle status
    $('.toggle-status').click(function() {
        const projectId = $(this).data('id');
        const button = $(this);
        
        $.ajax({
            url: `/admin/projects/${projectId}/toggle-status`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload(); // Reload to update the page
                }
            },
            error: function() {
                showAlert('error', 'Failed to update project status.');
            }
        });
    });
    
    // Toggle featured
    $('.toggle-featured').click(function() {
        const projectId = $(this).data('id');
        const button = $(this);
        
        $.ajax({
            url: `/admin/projects/${projectId}/toggle-featured`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload(); // Reload to update the page
                }
            },
            error: function() {
                showAlert('error', 'Failed to update project featured status.');
            }
        });
    });
    
    // Delete project
    $('.delete-project').click(function() {
        const projectId = $(this).data('id');
        const projectTitle = $(this).data('title');
        
        $('#project-title').text(projectTitle);
        $('#delete-form').attr('action', `/admin/projects/${projectId}`);
        $('#deleteModal').modal('show');
    });
    
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alert = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas ${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('.content-area').prepend(alert);
        
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush
