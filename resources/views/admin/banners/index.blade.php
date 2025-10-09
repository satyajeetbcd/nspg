@extends('admin.layouts.app')

@section('title', 'Banner Management - NSPG')
@section('page-title', 'Banner Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">Banner Management</h1>
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Add New Banner
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-images me-2"></i>
            All Banners
        </h5>
    </div>
    <div class="card-body">
        @if($banners->count() > 0)
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Button Text</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td>
                                @if($banner->image_path)
                                    <img src="{{ asset('/' . $banner->image_path) }}" 
                                         alt="{{ $banner->image_alt }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 40px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($banner->title, 30) }}</td>
                            <td>{{ Str::limit($banner->description, 50) }}</td>
                            <td>{{ $banner->button_text ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm {{ $banner->is_active ? 'btn-success' : 'btn-danger' }} toggle-status"
                                        data-id="{{ $banner->id }}"
                                        data-status="{{ $banner->is_active ? 'active' : 'inactive' }}">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $banner->sort_order }}</span>
                            </td>
                            <td>{{ $banner->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.banners.show', $banner) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.banners.edit', $banner) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-banner" 
                                            data-id="{{ $banner->id }}"
                                            data-title="{{ $banner->title }}"
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
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No banners found</h5>
                <p class="text-muted">Get started by creating your first banner.</p>
                <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create First Banner
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
                <p>Are you sure you want to delete this banner?</p>
                <p><strong id="banner-title"></strong></p>
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
        const bannerId = $(this).data('id');
        const button = $(this);
        
        $.ajax({
            url: `/admin/banners/${bannerId}/toggle-status`,
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
                showAlert('error', 'Failed to update banner status.');
            }
        });
    });
    
    // Delete banner
    $('.delete-banner').click(function() {
        const bannerId = $(this).data('id');
        const bannerTitle = $(this).data('title');
        
        $('#banner-title').text(bannerTitle);
        $('#delete-form').attr('action', `/admin/banners/${bannerId}`);
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
