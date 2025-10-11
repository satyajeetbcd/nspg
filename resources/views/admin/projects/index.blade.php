@extends('admin.layouts.app')

@section('title', 'Project Management - NSPG')
@section('page-title', 'Project Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">Project Management</h1>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Add New Project
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-solar-panel me-2"></i>
            All Projects
        </h5>
    </div>
    <div class="card-body">
        @if($projects->count() > 0)
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Order</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>
                                @if($project->image_path)
                                    <img src="{{ asset('/' . $project->image_path) }}" 
                                         alt="{{ $project->image_alt }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 40px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($project->title, 30) }}</td>
                            <td>
                                <span class="badge bg-info">{{ $project->project_type_label }}</span>
                            </td>
                            <td>{{ Str::limit($project->location, 20) }}</td>
                            <td>{{ $project->capacity ?? '-' }}</td>
                            <td>{{ $project->formatted_cost }}</td>
                            <td>
                                <button class="btn btn-sm {{ $project->is_active ? 'btn-success' : 'btn-danger' }} toggle-status"
                                        data-id="{{ $project->id }}"
                                        data-status="{{ $project->is_active ? 'active' : 'inactive' }}">
                                    {{ $project->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-sm {{ $project->is_featured ? 'btn-warning' : 'btn-outline-warning' }} toggle-featured"
                                        data-id="{{ $project->id }}"
                                        data-featured="{{ $project->is_featured ? 'featured' : 'not-featured' }}">
                                    {{ $project->is_featured ? 'Featured' : 'Not Featured' }}
                                </button>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $project->sort_order }}</span>
                            </td>
                            <td>{{ $project->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.projects.show', $project) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $project) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-project" 
                                            data-id="{{ $project->id }}"
                                            data-title="{{ $project->title }}"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-solar-panel fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No projects found</h5>
                <p class="text-muted">Get started by creating your first project.</p>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create First Project
                </a>
            </div>
        @endif
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
                    if (response.is_active) {
                        button.removeClass('btn-danger').addClass('btn-success').text('Active');
                    } else {
                        button.removeClass('btn-success').addClass('btn-danger').text('Inactive');
                    }
                    
                    // Show success message
                    showAlert('success', response.message);
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
                    if (response.is_featured) {
                        button.removeClass('btn-outline-warning').addClass('btn-warning').text('Featured');
                    } else {
                        button.removeClass('btn-warning').addClass('btn-outline-warning').text('Not Featured');
                    }
                    
                    // Show success message
                    showAlert('success', response.message);
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
