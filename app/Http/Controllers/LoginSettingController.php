<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginSetting;

class LoginSettingController extends Controller
{
    // Get current login settings
    public function index()
    {
        $settings = LoginSetting::first(); // Assuming only one row
        return response()->json($settings);
    }

    // Save or update login settings
    public function update(Request $request)
    {
        $validated = $request->validate([
            'partner_login' => 'required|boolean',
            'customer_login' => 'required|boolean',
            'employee_login' => 'required|boolean',
            'admin_login' => 'required|boolean',
            'password_reset' => 'required|boolean',
        ]);

        $settings = LoginSetting::updateOrCreate(['id' => 1], $validated);

        return response()->json(['message' => 'Settings updated successfully', 'data' => $settings]);
    }
}
