@extends('admin.layouts.app')

@section('title', 'What\'s New Management - NSPG')
@section('page-title', 'What\'s New Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">What's New Management</h1>
            <a href="{{ route('admin.whats-new.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Add New Item
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-newspaper me-2"></i>
            All What's New Items
        </h5>
    </div>
    <div class="card-body">
        @if($whatsNew->count() > 0)
            <div class="table-responsive">
                <table class="table" id="whats-new-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Publish Date</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($whatsNew as $item)
                        <tr>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" 
                                         alt="{{ $item->title }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 40px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->title }}</strong>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="{{ strip_tags($item->description) }}">
                                    {!! Str::limit(strip_tags($item->description), 100) !!}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $item->publish_date->format('M d, Y') }}</span>
                            </td>
                            <td>
                                <form action="{{ route('admin.whats-new.toggle-status', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        <i class="fas fa-{{ $item->is_active ? 'check' : 'times' }}"></i>
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $item->sort_order }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $item->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.whats-new.show', $item) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.whats-new.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.whats-new.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $whatsNew->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No What's New items found</h5>
                <p class="text-muted">Start by adding your first What's New item.</p>
                <a href="{{ route('admin.whats-new.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add New Item
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Check if DataTable is already initialized
    if (!$.fn.DataTable.isDataTable('#whats-new-table')) {
        $('#whats-new-table').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[6, 'desc']], // Sort by created date
            columnDefs: [
                { orderable: false, targets: [0, 7] } // Disable sorting for image and actions columns
            ],
            language: {
                emptyTable: "No What's New items found",
                zeroRecords: "No matching records found"
            }
        });
    }
});
</script>
@endpush
