@extends('admin.layouts.app')

@section('title', 'Calculator Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Calculator Settings</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Calculator Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Solar Calculator Configuration</h5>
                        <div>
                           
                            <a href="{{ route('home') }}" class="btn btn-info" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>View Calculator
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Setting</th>
                                    <th>Value</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($settings as $setting)
                                <tr>
                                    <td>
                                        <strong>{{ ucwords(str_replace('_', ' ', $setting->setting_key)) }}</strong>
                                    </td>
                                    <td>
                                        @if($setting->setting_type === 'boolean')
                                            <span class="badge {{ $setting->setting_value ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $setting->setting_value ? 'Yes' : 'No' }}
                                            </span>
                                        @elseif($setting->setting_type === 'number')
                                            <code>{{ $setting->setting_value }}</code>
                                        @else
                                            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $setting->setting_value }}">
                                                {{ $setting->setting_value }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($setting->setting_type) }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $setting->description ?: 'No description' }}</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm toggle-status {{ $setting->is_active ? 'btn-success' : 'btn-secondary' }}"
                                                data-id="{{ $setting->id }}"
                                                data-status="{{ $setting->is_active }}">
                                            {{ $setting->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.calculator.show', $setting->id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.calculator.edit', $setting->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-calculator fa-3x mb-3"></i>
                                            <p>No calculator settings found. <a href="{{ route('admin.calculator.reset-defaults') }}">Initialize with defaults</a></p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const settingId = this.dataset.id;
            const currentStatus = this.dataset.status === '1';
            
            fetch(`/admin/calculator/${settingId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.dataset.status = data.is_active ? '1' : '0';
                    this.textContent = data.is_active ? 'Active' : 'Inactive';
                    this.className = `btn btn-sm toggle-status ${data.is_active ? 'btn-success' : 'btn-secondary'}`;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endpush
