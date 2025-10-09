@extends('staff.layouts.master')
@section('page-title', __('Super Admin Dashboard'))

@section('action-btn')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('staff.plans.create') }}"
            class="btn btn-sm btn-primary d-flex align-items-center gap-1 shadow-sm rounded-pill px-3">
            <i class="fas fa-plus"></i> <span>{{ __('Add New Plan') }}</span>
        </a>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fas fa-box me-1"></i>{{ __('Manage Plans') }}
    </li>
@endsection
@section('content')
    {{-- KPI Summary --}}


    {{-- KPI Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card kpi-card text-center p-5">
                <div class="card-body">
                    <i class="fas fa-arrow-up-right-circle display-4 text-primary mb-3"></i>
                    <h6 class="fw-semibold text-muted">{{ __('Total Plans') }}</h6>
                    <h3 class="fw-bold text-primary">{{ $plans->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card kpi-card text-center p-3">
                <div class="card-body">
                    <i class="fas fa-check-circle display-4 text-success mb-3"></i>
                    <h6 class="fw-semibold text-muted">{{ __('Active Plans') }}</h6>
                    <h3 class="fw-bold text-success">{{ $plans->where('is_disable', false)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card kpi-card text-center p-3">
                <div class="card-body">
                    <i class="fas fa-eye display-4 text-info mb-3"></i>
                    <h6 class="fw-semibold text-muted">{{ __('Visible Plans') }}</h6>
                    <h3 class="fw-bold text-info">{{ $plans->where('is_visible', true)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card kpi-card text-center p-5">
                <div class="card-body">
                    <i class="fas fa-people display-4 text-warning mb-3"></i>
                    <h6 class="fw-semibold text-muted">{{ __('Total Subscribers') }}</h6>
                    <h3 class="fw-bold text-warning">{{ $plans->sum('subscribers_count') ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Plans Table --}}
    <div class="card mb-2">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-white">
                    <i class="fas fa-list-ul me-2"></i>{{ __('Plans List') }}
                </h5>
                <div class="d-flex gap-2 mb-2">
                    <div class="form-floating" style="width: 200px;">
                        <select id="filterDuration" class="form-select text-center">
                            <option value="">{{ __('All Durations') }}</option>
                            <option value="month">{{ __('Monthly') }}</option>
                            <option value="year">{{ __('Yearly') }}</option>
                        </select>
                        <label class="text-center align-middle" for="filterDuration" >{{ __('Filter by Duration') }}</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-3">

                <div class="table-responsive">
                    <table id="plans" class="table dark datatable align-middle table-hover mb-0 rounded-3 overflow-visible">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Countries') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Max User') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Active') }}</th>
                                <th>{{ __('Features') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($plans as $plan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $plan->name }}</td>
                                    <td><span class="badge bg-info-subtle text-dark">Egypt</span></td>
                                    <td data-duration="{{ $plan->duration }}">{{ $plan->duration }}</td>
                                    <td>{{ $plan->max_users < 0 ? 'Unlimited' : $plan->max_users }}</td>
                                    <td>{{ $plan->created_at->format('d M Y') }}</td>

                                    {{-- Active Toggle --}}
                                    <td>
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input toggle-status" type="checkbox"
                                                data-url="{{ route('staff.plans.toggle-status', ['locale' => $uiLocale, 'plan' => $plan->id]) }}"
                                                data-type="active" data-id="{{ $plan->id }}"
                                                id="activeSwitch{{ $plan->id }}"
                                                {{ $plan->is_disable ? '' : 'checked' }}>
                                        </div>
                                    </td>


                                    {{-- Features --}}
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @if($plan->features && $plan->features->count() > 0)
                                                @foreach ($plan->features as $feature)
                                                    @if(method_exists($feature, 'planModules'))
                                                        @foreach ($feature->planModules() as $activeFeature)
                                                            <span class="badge bg-success-subtle text-success">
                                                                <i class="fas fa-check-circle me-1"></i> {{ $activeFeature }}
                                                            </span>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">
                                                    <i class="fas fa-dash-circle me-1"></i> {{ __('No Features') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Actions --}}
                                    <td>
                                        <div class="dropdown_menu">
                                            <button class="btn btn-sm btn-outline-primary" type="button"
                                                data-bs-toggle="dropdown_menu" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="{{ route('staff.plans.show', ['locale' => $uiLocale, 'plan' => $plan->id]) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-eye me-2 text-primary"></i>{{ __('View Details') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item"
                                                        data-url="{{ route('staff.plans.edit', ['plan' => $plan->id]) }}"
                                                        data-ajax-popup="true" data-title="{{ __('Edit Plan') }}"
                                                        data-size="lg">
                                                        <i class="fas fa-pencil-square me-2 text-warning"></i>{{ __('Edit Plan') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('staff.plans.subscribers', ['locale' => $uiLocale, 'plan' => $plan->id]) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-people me-2 text-info"></i>{{ __('View Subscribers') }}
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button class="dropdown-item text-danger itemDelete"
                                                        data-item_id="{{ $plan->id }}"
                                                        data-url="{{ route('staff.plans.destroy', $plan->id) }}"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                        <i class="fas fa-trash me-2"></i>{{ __('Delete Plan') }}
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-arrow-up-right-circle display-1 text-muted mb-3"></i>
                                            <h5 class="text-muted">{{ __('No Plans Found') }}</h5>
                                            <p class="text-muted">{{ __('Create your first plan to get started') }}</p>
                                            <a href="{{ route('staff.plans.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus-circle me-1"></i> {{ __('Create Plan') }}
                                            </a>
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

    {{-- Delete Confirmation Modal --}}
    @include('partials.confirm-modal', [
        'id' => 'deleteModal',
        'title' => __('Delete Plan'),
        'message' => __('Are you sure you want to delete this plan?'),
        'confirmBtnId' => 'confirmDelete',
    ])

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle status functionality
    document.querySelectorAll('.toggle-status').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const url = this.dataset.url;
            const isChecked = this.checked;
            
            // Show loading state
            this.disabled = true;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: isChecked ? 'active' : 'inactive'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showAlert('success', data.message || 'Plan status updated successfully');
                } else {
                    // Revert toggle state
                    this.checked = !isChecked;
                    showAlert('error', data.message || 'Failed to update plan status');
                }
            })
            .catch(error => {
                // Revert toggle state
                this.checked = !isChecked;
                showAlert('error', 'An error occurred while updating plan status');
                console.error('Error:', error);
            })
            .finally(() => {
                // Re-enable toggle
                this.disabled = false;
            });
        });
    });

    // Filter functionality
    document.getElementById('filterDuration').addEventListener('change', function() {
        const selectedDuration = this.value;
        const tableRows = document.querySelectorAll('#plans tbody tr');
        
        tableRows.forEach(function(row) {
            const durationCell = row.querySelector('td[data-duration]');
            if (durationCell) {
                const rowDuration = durationCell.getAttribute('data-duration');
                
                if (selectedDuration === '' || rowDuration === selectedDuration) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Show alert function
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Insert alert at the top of the content
        const content = document.querySelector('.fade-in');
        content.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const alert = content.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>
@endpush
