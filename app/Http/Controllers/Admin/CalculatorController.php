<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculatorSetting;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        $settings = CalculatorSetting::orderBy('setting_key')->get();
        return view('admin.calculator.index', compact('settings'));
    }

    public function show(CalculatorSetting $calculator)
    {
        return view('admin.calculator.show', compact('calculator'));
    }

    public function edit(CalculatorSetting $calculator)
    {
        return view('admin.calculator.edit', compact('calculator'));
    }

    public function update(Request $request, CalculatorSetting $calculator)
    {
        try {
            $request->validate([
                'setting_value' => 'required',
                'description' => 'nullable|string|max:500',
                'is_active' => 'nullable'
            ]);

            $calculator->update([
                'setting_value' => $request->setting_value,
                'description' => $request->description,
                'is_active' => $request->has('is_active')
            ]);

            return redirect()->route('admin.calculator.index')
                ->with('success', 'Calculator setting updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating setting: ' . $e->getMessage());
        }
    }

    public function toggleStatus(CalculatorSetting $setting)
    {
        $setting->update(['is_active' => !$setting->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $setting->is_active
        ]);
    }

    public function resetToDefaults()
    {
        // Reset all calculator settings to default values
        $defaults = [
            'cost_per_unit' => ['value' => '6', 'type' => 'number', 'description' => 'Cost per unit of electricity in ₹'],
            'units_per_kw_per_month' => ['value' => '120', 'type' => 'number', 'description' => 'Average units generated per kW per month'],
            'space_per_kw' => ['value' => '80', 'type' => 'number', 'description' => 'Space required per kW in sqft'],
            'cost_per_watt' => ['value' => '50', 'type' => 'number', 'description' => 'Cost per watt in ₹'],
            'subsidy_per_watt' => ['value' => '20', 'type' => 'number', 'description' => 'Subsidy per watt in ₹'],
            'max_subsidy' => ['value' => '75000', 'type' => 'number', 'description' => 'Maximum subsidy amount in ₹'],
            'nspg_discount_percentage' => ['value' => '10', 'type' => 'number', 'description' => 'NSPG discount percentage'],
            'max_nspg_discount' => ['value' => '22000', 'type' => 'number', 'description' => 'Maximum NSPG discount in ₹'],
            'calculator_title' => ['value' => 'NSPG Solar Calculator', 'type' => 'text', 'description' => 'Calculator title'],
            'calculator_subtitle' => ['value' => 'Calculate Your Savings', 'type' => 'text', 'description' => 'Calculator subtitle'],
            'calculator_description' => ['value' => 'Explore the potential of solar energy and start saving from Day One!', 'type' => 'text', 'description' => 'Calculator description'],
            'cta_button_text' => ['value' => 'Book Free Consultation', 'type' => 'text', 'description' => 'Call-to-action button text'],
            'is_calculator_enabled' => ['value' => '1', 'type' => 'boolean', 'description' => 'Enable/disable calculator on homepage']
        ];

        foreach ($defaults as $key => $config) {
            CalculatorSetting::setValue(
                $key,
                $config['value'],
                $config['type'],
                $config['description']
            );
        }

        return redirect()->route('admin.calculator.index')
            ->with('success', 'Calculator settings reset to defaults successfully.');
    }
}