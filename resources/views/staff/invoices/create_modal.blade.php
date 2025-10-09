{{-- Modal Body --}}
<div class="modal-body">
    <x-form id="customerForm" action="{{ route('staff.invoices.store') }}" method="POST" :axios="true">
        <div class="row">
            {{-- User Select --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">{{ __('Select User') }}</label>
                    <select name="subscription_id" class="  form-control select2  "
                        data-placeholder="{{ __('Select a User') }}" required>
                        <option value="" disabled selected>{{ __('Select a User') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                        <div class="invalid-feedback">Please enter a valid Email.</div>
                    </select>
                </div>
            </div>

            {{-- Plan Select --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">{{ __('Select Plan') }}</label>
                    <select name="plan_id" class="  form-control select2 " data-placeholder="{{ __('Select a Plan') }}"
                        required>
                        <option value="" disabled selected>{{ __('Select a Plan') }}</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }} - {{ $plan->price }}
                                {{ $plan->currency }}</option>
                        @endforeach
                        <div class="invalid-feedback">Please enter a valid Email.</div>
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" name="assignPlan" type="checkbox" id="assignPlanSwitch">
                    <label class="form-check-label" for="assignPlanSwitch">{{__('Assign Plan')}}</label>
                </div>

                <div id="switchStatus" class="mt-2 fw-bold text-primary">
                    {{__('Assign Plan For User')}} : <span class="text-danger">{{__('False')}}</span>
                </div>
            </div>

            <!-- Submit -->
            <div class="col-md-12 mt-3 text-center">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    {{ __('Create') }}
                </button>
            </div>
        </div>
    </x-form>
</div>
<style>
    /*  ===========================
            Select2 Creative Styles
        =========================== */

    /* Base container */
    .select2 {
        border-radius: 12px;
        height: 50px;
        font-size: 14px;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        overflow: auto;
        padding: 4px 10px;
        transition: border-color 0.3s, box-shadow 0.3s, background-color 0.3s;
    }

    /* Focus state */
    .select2:focus,
    .select2.select2-container--focus .select2-selection {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        background-color: #ffffff;
    }

    /* Placeholder & selected value */
    .select2 .select2-selection__rendered {
        line-height: 42px;
        color: #495057;
        font-weight: 500;
    }

    /* Arrow */
    .select2 .select2-selection__arrow {
        height: 42px;
        right: 10px;
    }

    /* Dropdown options */
    .select2-container--bootstrap-5 .select2-results__option {
        padding: 10px 12px;
        font-size: 14px;
        overflow-y: auto;
        color: #212529;
        transition: background-color 0.2s, color 0.2s;
    }

    /* Hover / highlighted option */
    .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: #0d6efd !important;
        color: white !important;
        font-weight: 500;
    }

    /* Valid / invalid state */
    .select2.is-valid .select2-selection {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }

    .select2.is-invalid .select2-selection {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    /* Add subtle hover effect for dropdown */
    .select2-container--bootstrap-5 .select2-results__option:hover {
        background-color: #e9f2ff !important;
        color: #0d6efd !important;
    }

    /* Optional: Add small icon inside dropdown (creative touch) */
    .select2-results__option::before {
        content: "\f007";
        /* FontAwesome user icon */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        display: inline-block;
        width: 20px;
        margin-right: 6px;
        color: #0d6efd;
    }
</style>

<script>
    $(document).ready(function() {

        select_search();
    });

    $(document).ready(function() {
        let assignPlan = false;

        $('#assignPlanSwitch').on('change', function() {
            assignPlan = $(this).is(':checked');
            $('#switchStatus span')
                .text(assignPlan ? 'True' : 'False')
                .toggleClass('text-success', assignPlan)
                .toggleClass('text-danger', !assignPlan);
            console.log('assignPlan:', assignPlan);
        });
    });
</script>
