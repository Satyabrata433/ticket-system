<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    public function show()
    {
        $setting = CompanySetting::first();
        return response()->json($setting);
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:100',
            'company_email' => 'required|email|max:100',
            'company_phone' => 'required|string|max:15',
            'date_format' => 'required|string|max:20',
            'company_address' => 'required|string',
            'admin_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'customer_portal_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $setting = CompanySetting::first() ?? new CompanySetting();

        $setting->company_name = $request->company_name;
        $setting->company_email = $request->company_email;
        $setting->company_phone = $request->company_phone;
        $setting->date_format = $request->date_format;
        $setting->company_address = $request->company_address;

        // Handle logos
        if ($request->hasFile('admin_logo')) {
            if ($setting->admin_logo && Storage::disk('public')->exists($setting->admin_logo)) {
                Storage::disk('public')->delete($setting->admin_logo);
            }
            $setting->admin_logo = $request->file('admin_logo')->store('logos', 'public');
        }

        if ($request->hasFile('customer_portal_logo')) {
            if ($setting->customer_portal_logo && Storage::disk('public')->exists($setting->customer_portal_logo)) {
                Storage::disk('public')->delete($setting->customer_portal_logo);
            }
            $setting->customer_portal_logo = $request->file('customer_portal_logo')->store('logos', 'public');
        }

        $setting->save();

        return response()->json([
            'message' => 'Company settings updated successfully',
            'data' => $setting,
        ]);
    }
}
