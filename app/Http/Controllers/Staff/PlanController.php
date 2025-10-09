<?php

namespace App\Http\Controllers\Staff;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Plan;
use App\Models\Customer;
use App\Models\PlanFeature;
use App\Models\PlanPrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with(['features', 'prices'])
            ->withCount([
                'subscriptions as active_subscriptions_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->latest()
            ->paginate(15);




        return view('staff.plans.index', compact('plans'));
    }

    public function create()
    {
        $countries = Country::orderBy('id')->with(['countryLanguages', 'currencies', 'currencies.currencyLanguages'])->get();
        $currencies = Currency::orderBy('id')->get();
        return view('staff.plans.create', compact('countries', 'currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'period'            => 'required|in:month,year',
            'max_user'          => 'required|integer|min:1',
            'basic_features'    => 'nullable|array',
            'basic_features.*'  => 'string|in:Accounts,CRM,POS,HRM,Project,Manufacture',
            'prices'            => 'nullable|array',
            'prices.*.country'  => 'nullable|integer|exists:country,id',
            'prices.*.currency' => 'nullable|integer|exists:currency,id',
            'prices.*.amount'   => 'nullable|numeric|min:0',
        ]);

        // Create the plan
        $plan = Plan::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'duration' => $validated['period'],
            'max_users' => $validated['max_user'],
            'is_disable' => null, // Active by default
            'is_visible' => 1, // Visible by default
        ]);

        // Create plan features
        $planFeatures = PlanFeature::create(['plan_id' => $plan->id]);
        $planFeatures->max_user = $validated['max_user'];

        // Map feature names to DB columns
        $modulesMap = [
            'Accounts'    => 'module_account',
            'CRM'         => 'module_crm',
            'POS'         => 'module_pos',
            'HRM'         => 'module_hrm',
            'Project'     => 'module_project',
            'Manufacture' => 'module_manfucture',
        ];

        // Reset all modules to disabled (0)
        foreach ($modulesMap as $col) {
            $planFeatures->$col = 0;
        }

        // Enable selected modules only
        foreach ($validated['basic_features'] ?? [] as $feature) {
            if (isset($modulesMap[$feature])) {
                $planFeatures->{$modulesMap[$feature]} = 1;
            }
        }
        $planFeatures->save();

        // Create plan prices
        if (!empty($validated['prices'])) {
            foreach ($validated['prices'] as $priceData) {
                if (!empty($priceData['country']) && !empty($priceData['currency']) && !empty($priceData['amount'])) {
                    PlanPrice::create([
                        'plan_id'     => $plan->id,
                        'country_id'  => $priceData['country'],
                        'currency_id' => $priceData['currency'],
                        'price'       => $priceData['amount'],
                    ]);
                }
            }
        }

        return redirect()->route('staff.plans.index', ['locale' => app()->getLocale()])
            ->with('success', 'Plan created successfully.');
    }

    public function show($locale, Plan $plan)
    {
        // Load relationships and counts
        $plan->load(['features', 'prices.country', 'prices.currency']);
        $plan->loadCount('subscribers');

        return view('staff.plans.show', compact('plan'));
    }

    public function edit($locale, Plan $plan)
    {
        $countries = Country::orderBy('id')->with(['countryLanguages', 'currencies', 'currencies.currencyLanguages'])->get();
        $currencies = Currency::orderBy('id')->get();
        return view('staff.plans.edit', compact('countries', 'currencies', 'plan'));
    }

    /**
     * Update an existing plan with details, features, and pricing.
     *
     * This method handles the following:
     * 1. Validate request data (plan info, features, and prices).
     * 2. Update base plan info (description, duration).
     * 3. Update language-specific fields via Plan::updateLanguage().
     * 4. Update plan features (max users + enabled/disabled modules).
     * 5. Delete removed plan prices.
     * 6. Update or create plan prices (per country/currency).
     *
     * @param  Request  $request  Incoming request with plan update data
     * @param  string   $locale   Current locale (for translations)
     * @param  Plan     $plan     The plan being updated
     * @return JsonResponse
     */
    public function update(Request $request, $locale, Plan $plan): JsonResponse
    {
        // 🔹 Step 1: Validate request data
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'period'            => 'required|in:month,year',
            'max_user'          => 'required|integer|min:1',

            // Features validation
            'basic_features'    => 'nullable|array',
            'basic_features.*'  => 'string|in:Accounts,CRM,POS,HRM,Project,Manufacture',

            // Pricing validation
            'prices'            => 'nullable|array',
            'prices.*.country'  => 'nullable|integer|exists:country,id',
            'prices.*.currency' => 'nullable|integer|exists:currency,id',
            'prices.*.amount'   => 'nullable|numeric|min:0',

            // Deleted price IDs
            'deleted_prices'    => 'nullable|array',
            'deleted_prices.*'  => 'integer',
        ]);

        // 🔹 Step 2: Update plan base info
        $plan->update([
            'description' => $validated['description'] ?? $plan->description,
            'duration'    => $validated['period'],
        ]);

        // 🔹 Step 3: Update language-specific info if supported
        if (method_exists($plan, 'updateLanguage')) {
            $plan->updateLanguage(
                $plan->id,
                $validated['description'] ?? $plan->description,
                $validated['name']
            );
        }

        // 🔹 Step 4: Update plan features
        $planFeatures = PlanFeature::firstOrCreate(['plan_id' => $plan->id]);
        $planFeatures->max_user = $validated['max_user'];

        // Map feature names to DB columns
        $modulesMap = [
            'Accounts'    => 'module_account',
            'CRM'         => 'module_crm',
            'POS'         => 'module_pos',
            'HRM'         => 'module_hrm',
            'Project'     => 'module_project',
            'Manufacture' => 'module_manfucture',
        ];

        // Reset all modules to disabled (0)
        foreach ($modulesMap as $col) {
            $planFeatures->$col = 0;
        }

        // Enable selected modules only
        foreach ($validated['basic_features'] ?? [] as $feature) {
            if (isset($modulesMap[$feature])) {
                $planFeatures->{$modulesMap[$feature]} = 1;
            }
        }
        $planFeatures->save();
        // 🔹 Step 5: Delete removed prices
        $deletedPriceIds = $validated['deleted_prices'] ?? [];
        if (!empty($deletedPriceIds)) {
            $deletePricies =    PlanPrice::where('plan_id', $plan->id)
                ->whereIn('id', $deletedPriceIds)
                ->delete();
        }

        // 🔹 Step 6: Update or create prices
        // 🔹 Step 5: Delete removed prices
        $deletedPriceIds = $validated['deleted_prices'] ?? [];
        if (!empty($deletedPriceIds)) {
            PlanPrice::where('plan_id', $plan->id)
                ->whereIn('id', $deletedPriceIds)
                ->delete();
        }

        // 🔹 Step 6: Update or create prices (skip deleted ones)
        if (!empty($validated['prices'])) {
            foreach ($validated['prices'] as $key => $priceData) {
                // Skip if this price was marked for deletion
                if (in_array($key, $deletedPriceIds)) {
                    continue;
                }

                // Skip invalid entries
                if (empty($priceData['country']) || empty($priceData['currency']) || empty($priceData['amount'])) {
                    continue;
                }

                if (is_numeric($key)) {
                    // Existing → update
                    PlanPrice::updateOrCreate(
                        ['id' => $key, 'plan_id' => $plan->id],
                        [
                            'country_id'  => $priceData['country'],
                            'currency_id' => $priceData['currency'],
                            'price'       => $priceData['amount'],
                        ]
                    );
                } else {
                    // New → create
                    PlanPrice::create([
                        'plan_id'     => $plan->id,
                        'country_id'  => $priceData['country'],
                        'currency_id' => $priceData['currency'],
                        'price'       => $priceData['amount'],
                    ]);
                }
            }
        }


        // 🔹 Response
        return response()->json(['message' => __('Plan updated successfully')], 200);
    }



    public function destroy($locale, Plan $plan)
    {
        $plan->features()->delete();
        if ($plan->delete()) {
            # code...
            return response()->json(['message' => __('Plan updated successfully')], 200);
        };
    }
    /**
     * Toggle the status of a given plan (enable/disable).
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\JsonResponse
     *
     * This method is API-oriented:
     * - Uses JSON responses instead of redirects/flash messages.
     * - Provides a clear success flag, user-friendly message, and updated plan data.
     * - Business rule: `is_disable = null` means enabled, `1` means disabled.
     */
    public function toggleStatus($locale, Plan $plan): JsonResponse
    {
        // Flip current disable flag
        if ($plan->subscribers()->exists()) {
            return response()->json([
                'message' => 'This plan currently has active subscriptions and cannot be modified.'
            ], 200); // Explicit HTTP status for clarity
        }

        $isDisabled = !$plan->is_disable;

        // Update persistence layer
        $plan->update([
            'is_disable' => $isDisabled ? 1 : null,
        ]);

        // Build response payload
        return response()->json([
            'success' => true,
            'message' => sprintf(
                'Plan %s successfully.',
                $isDisabled ? 'disabled' : 'enabled'
            ),
            'data' => [
                'id'         => $plan->id,
                'is_disable' => $plan->is_disable,
                'status'     => $isDisabled ? 'disabled' : 'enabled',
            ],
        ], 200); // Explicit HTTP status for clarity
    }

    public function toggleVisibility($locale, Plan $plan)
    {
        $new = !$plan->is_visible;
        $plan->update(['is_visible' => $new ? 1 : null]);
        $visibility = $new ? 'visible' : 'hidden';


        return  response()->json(['message' => __("Plan $visibility Succssfully")], 200);
    }

    public function subscribers($locale, Plan $plan)
    {
        $customers = Customer::where('plan', $plan->id)->with('plan')->paginate(15);
        return view('staff.plans.subscribers', compact('plan', 'customers'));
    }

    public function getActivePlans()
    {
        $plans = Plan::whereNull('is_disable')->get(['id', 'name', 'price']);
        return response()->json($plans);
    }
}
