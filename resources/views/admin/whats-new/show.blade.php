@extends('admin.layouts.app')

@section('title', 'View What\'s New Item - NSPG')
@section('page-title', 'View What\'s New Item')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        View What's New Item
                    </h5>
                    <div class="btn-group">
                        <a href="{{ route('admin.whats-new.edit', $whatsNew) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            Edit
                        </a>
                        <a href="{{ route('admin.whats-new.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h3 class="text-primary">{{ $whatsNew->title }}</h3>
                            <div class="d-flex gap-3 mb-3">
                                <span class="badge bg-{{ $whatsNew->is_active ? 'success' : 'secondary' }} fs-6">
                                    <i class="fas fa-{{ $whatsNew->is_active ? 'check' : 'times' }} me-1"></i>
                                    {{ $whatsNew->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="badge bg-info fs-6">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $whatsNew->publish_date->format('M d, Y') }}
                                </span>
                                <span class="badge bg-primary fs-6">
                                    <i class="fas fa-sort me-1"></i>
                                    Order: {{ $whatsNew->sort_order }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-dark">Description</h5>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($whatsNew->description)) !!}
                            </div>
                        </div>

                        @if($whatsNew->hindi_description)
                        <div class="mb-4">
                            <h5 class="text-dark">Hindi Description</h5>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($whatsNew->hindi_description)) !!}
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        @if($whatsNew->image)
                        <div class="mb-4">
                            <h5 class="text-dark">Image</h5>
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $whatsNew->image) }}" 
                                     alt="{{ $whatsNew->title }}" 
                                     class="img-fluid rounded shadow">
                            </div>
                        </div>
                        @endif

                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">Item Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-5"><strong>ID:</strong></div>
                                    <div class="col-7">{{ $whatsNew->id }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Status:</strong></div>
                                    <div class="col-7">
                                        <span class="badge bg-{{ $whatsNew->is_active ? 'success' : 'secondary' }}">
                                            {{ $whatsNew->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Sort Order:</strong></div>
                                    <div class="col-7">{{ $whatsNew->sort_order }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Publish Date:</strong></div>
                                    <div class="col-7">{{ $whatsNew->publish_date->format('M d, Y') }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Created:</strong></div>
                                    <div class="col-7">{{ $whatsNew->created_at->format('M d, Y H:i') }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Updated:</strong></div>
                                    <div class="col-7">{{ $whatsNew->updated_at->format('M d, Y H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <form action="{{ route('admin.whats-new.toggle-status', $whatsNew) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-{{ $whatsNew->is_active ? 'warning' : 'success' }} w-100 mb-2">
                                    <i class="fas fa-{{ $whatsNew->is_active ? 'eye-slash' : 'eye' }} me-1"></i>
                                    {{ $whatsNew->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.whats-new.destroy', $whatsNew) }}" method="POST" 
                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-1"></i>
                                    Delete Item
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
