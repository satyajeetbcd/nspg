@extends('admin.layouts.app')

@section('title', 'Edit Banner - NSPG')
@section('page-title', 'Edit Banner')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">Edit Banner</h1>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Banners
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Banner Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $banner->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="image_alt" class="form-label">Image Alt Text</label>
                            <input type="text" 
                                   class="form-control @error('image_alt') is-invalid @enderror" 
                                   id="image_alt" 
                                   name="image_alt" 
                                   value="{{ old('image_alt', $banner->image_alt) }}">
                            @error('image_alt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4">{{ old('description', $banner->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="button_text" class="form-label">Button Text</label>
                            <input type="text" 
                                   class="form-control @error('button_text') is-invalid @enderror" 
                                   id="button_text" 
                                   name="button_text" 
                                   value="{{ old('button_text', $banner->button_text) }}">
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="button_url" class="form-label">Button URL</label>
                            <input type="url" 
                                   class="form-control @error('button_url') is-invalid @enderror" 
                                   id="button_url" 
                                   name="button_url" 
                                   value="{{ old('button_url', $banner->button_url) }}">
                            @error('button_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $banner->sort_order) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Banner Image</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        <div class="form-text">Leave empty to keep current image. Any image format supported. Max size: 10MB</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-image me-2"></i>
                    Current Image
                </h5>
            </div>
            <div class="card-body">
                @if($banner->image_path)
                    <img src="{{ asset($banner->image_path) }}" 
                         alt="{{ $banner->image_alt }}" 
                         class="img-fluid rounded">
                @else
                    <div class="text-center text-muted">
                        <i class="fas fa-image fa-3x mb-3"></i>
                        <p>No image uploaded</p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Banner Guidelines
                </h5>
            </div>
            <div class="card-body">
                <h6>Image Requirements:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i> Recommended size: 1920x1080px</li>
                    <li><i class="fas fa-check text-success me-2"></i> Aspect ratio: 16:9</li>
                    <li><i class="fas fa-check text-success me-2"></i> Max file size: 10MB</li>
                    <li><i class="fas fa-check text-success me-2"></i> All image formats supported</li>
                </ul>
                
                <h6 class="mt-4">Content Tips:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-lightbulb text-warning me-2"></i> Keep title concise and impactful</li>
                    <li><i class="fas fa-lightbulb text-warning me-2"></i> Use clear, readable fonts</li>
                    <li><i class="fas fa-lightbulb text-warning me-2"></i> Ensure good contrast with background</li>
                    <li><i class="fas fa-lightbulb text-warning me-2"></i> Include call-to-action button</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Image preview
    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing preview
                $('.image-preview').remove();
                
                // Add new preview
                const preview = `
                    <div class="image-preview mt-3">
                        <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                `;
                $('#image').after(preview);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
