@extends('admin.layouts.app')

@section('title', 'View Banner - NSPG')
@section('page-title', 'Banner Details')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">Banner Details</h1>
            <div>
                <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit me-2"></i>
                    Edit Banner
                </a>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Banners
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-image me-2"></i>
                    Banner Preview
                </h5>
            </div>
            <div class="card-body">
                @if($banner->image_path)
                    <div class="text-center">
                        <img src="{{ asset('/' . $banner->image_path) }}" 
                             alt="{{ $banner->image_alt }}" 
                             class="img-fluid rounded shadow"
                             style="max-height: 400px;">
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-image fa-3x mb-3"></i>
                        <p>No image uploaded</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Banner Information
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Title:</strong></td>
                        <td>{{ $banner->title }}</td>
                    </tr>
                    <tr>
                        <td><strong>Description:</strong></td>
                        <td>{{ $banner->description ?: 'No description' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Button Text:</strong></td>
                        <td>{{ $banner->button_text ?: 'No button' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Button URL:</strong></td>
                        <td>
                            @if($banner->button_url)
                                <a href="{{ $banner->button_url }}" target="_blank" class="text-decoration-none">
                                    {{ $banner->button_url }}
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            @else
                                No URL
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Sort Order:</strong></td>
                        <td>{{ $banner->sort_order }}</td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $banner->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Updated:</strong></td>
                        <td>{{ $banner->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
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
                    <button class="btn {{ $banner->is_active ? 'btn-warning' : 'btn-success' }} toggle-status"
                            data-id="{{ $banner->id }}"
                            data-status="{{ $banner->is_active ? 'active' : 'inactive' }}">
                        <i class="fas fa-power-off me-2"></i>
                        {{ $banner->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                    
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Banner
                    </a>
                    
                    <button type="button" 
                            class="btn btn-danger delete-banner" 
                            data-id="{{ $banner->id }}"
                            data-title="{{ $banner->title }}">
                        <i class="fas fa-trash me-2"></i>
                        Delete Banner
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
                        button.removeClass('btn-success').addClass('btn-warning').html('<i class="fas fa-power-off me-2"></i>Deactivate');
                    } else {
                        button.removeClass('btn-warning').addClass('btn-success').html('<i class="fas fa-power-off me-2"></i>Activate');
                    }
                    
                    // Update status badge
                    const statusBadge = $('.badge');
                    if (response.is_active) {
                        statusBadge.removeClass('bg-danger').addClass('bg-success').text('Active');
                    } else {
                        statusBadge.removeClass('bg-success').addClass('bg-danger').text('Inactive');
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
