<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $customer = Customer::with(['companies'])->find($customer->id);
        $company = $customer->primaryCompany;
        return view('customer.profile', compact('customer', 'company'));
    }

    public function show()
    {
        $customer = Auth::guard('customer')->user();
        $customer = Customer::with(['companies'])->find($customer->id);
        $company = $customer->primaryCompany;
        return view('customer.profile', compact('customer', 'company'));
    }

    public function update(Request $request, $customer = null)
    {
        // If customer ID is provided as string, resolve the Customer model
        if ($customer && is_string($customer)) {
            $customer = Customer::find($customer);
        }

        // If no customer provided, use the authenticated customer
        if (!$customer) {
            /** @var Customer $customer */
            $customer = Auth::guard('customer')->user();
        }

        // Ensure the customer can only update their own profile
        if ($customer->id !== Auth::guard('customer')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->only([
            'name',
            'email',
            'password',
        ]);

        // Validate required fields
        if (empty($validated['name']) || empty($validated['email'])) {
            return response()->json(['message' => 'Name and email are required'], 422);
        }

        $companyData = $request->only([
            'company_name',
            'cr_number',
            'vat_number',
            'phone',
            'billing_phone',
            'address',
            'language',
            'currency_id',
        ]);

        // Remove empty fields
        $validated = array_filter($validated, function($value) {
            return !is_null($value) && $value !== '';
        });

        $companyData = array_filter($companyData, function($value) {
            return !is_null($value) && $value !== '';
        });

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('uploads/avatar', 'public');
            $validated['avatar'] = $path;
        }

        try {
            // Update customer data
            $customer->fill($validated);
            $customer->save();

            // Update or create company data
            if (!empty($companyData)) {
                $company = $customer->primaryCompany;
                if (!$company) {
                    // Create new company if none exists
                    $companyData['customer_id'] = $customer->id;
                    $companyData['country_id'] = 1; // Default country
                    $companyData['city_id'] = 1; // Default city
                    $customer->companies()->create($companyData);
                } else {
                    // Update existing company
                    $company->update($companyData);
                }
            }

            return response()->json(['message' => 'Profile updated successfully!']);
        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating your profile. Please try again.'], 500);
        }
    }
}
