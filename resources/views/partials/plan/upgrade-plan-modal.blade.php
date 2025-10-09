{{-- Body --}}
<div class="modal-body">
    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-start">{{ __('Plan') }}</th>
                            <th class="text-center">{{ __('Users') }}</th>
                            <th class="text-center">{{ __('Features') }}</th>
                            <th class="text-center">{{ __('Trial') }}</th>
                            <th class="text-center">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $plan)
                            <tr class="border-bottom">
                                {{-- Plan Info --}}
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-primary">{{ $plan->name }}</span>
                                        <small class="text-muted">
                                            {{ isset($admin_payment_setting['currency']) ? $admin_payment_setting['currency'] : '$' }}{{ $plan->price }}
                                            {{ '/ ' . ucfirst($plan->duration) }}
                                        </small>
                                    </div>
                                </td>

                                {{-- Users --}}
                                <td class="text-center">
                                    @if($plan->features && $plan->features->count() > 0)
                                        @php $feature = $plan->features->first(); @endphp
                                        <span class="badge bg-secondary rounded-pill px-3">
                                            {{ $feature->max_user == -1 ? __('Unlimited') : $feature->max_user }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3">{{ __('N/A') }}</span>
                                    @endif
                                </td>

                                {{-- Features --}}
                                <td class="text-center">
                                    @if($plan->features && $plan->features->count() > 0)
                                        @php $feature = $plan->features->first(); @endphp
                                        <div class="d-flex flex-wrap gap-1 justify-content-center">
                                            @if($feature->module_account)
                                                <span class="badge bg-info text-dark rounded-pill px-2">{{ __('Accounting') }}</span>
                                            @endif
                                            @if($feature->module_crm)
                                                <span class="badge bg-success rounded-pill px-2">{{ __('CRM') }}</span>
                                            @endif
                                            @if($feature->module_hrm)
                                                <span class="badge bg-warning text-dark rounded-pill px-2">{{ __('HRM') }}</span>
                                            @endif
                                            @if($feature->module_project)
                                                <span class="badge bg-primary rounded-pill px-2">{{ __('Project') }}</span>
                                            @endif
                                            @if($feature->module_pos)
                                                <span class="badge bg-secondary rounded-pill px-2">{{ __('POS') }}</span>
                                            @endif
                                            @if($feature->module_manfucture)
                                                <span class="badge bg-dark rounded-pill px-2">{{ __('Manufacturing') }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="badge bg-light text-dark rounded-pill px-3">{{ __('Contact us') }}</span>
                                    @endif
                                </td>

                                {{-- Additional Info --}}
                                <td class="text-center">
                                    @if($plan->trial)
                                        <span class="badge bg-warning text-dark rounded-pill px-3">
                                            {{ $plan->trial_days ?? 0 }} {{ __('Days Trial') }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-muted rounded-pill px-3">{{ __('No Trial') }}</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    @if (isset($customer->getPlan) && $customer->getPlan->id == $plan->id)
                                        <button class="btn btn-sm btn-success shadow-sm px-3" disabled>
                                            <i class="bi bi-check-circle me-1"></i> {{ __('Current') }}
                                        </button>
                                    @else
                                        <a href="{{ route('dashboard.subscription.plan.active', [encrypt($customer?->id), encrypt($plan?->id)]) }}"
                                            class="btn btn-sm btn-outline-warning shadow-sm px-3"
                                            title="{{ __('Click to Upgrade Plan') }}">
                                            <i class="bi bi-arrow-up-circle me-1"></i> {{ __('Upgrade') }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-end bg-light rounded-bottom">
            <button class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-1"></i> {{ __('Close') }}
            </button>
        </div>
    </div>
</div>
