<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;

class SystemSettingController extends Controller
{
    // Get current system settings
    public function index()
    {
        $settings = SystemSetting::first();
        return response()->json($settings);
    }

    // Save or update system settings
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id_prefix' => 'required|string|max:10',
            'ticket_status' => 'required|string|max:20',
            'allow_customer' => 'required|boolean',
            'internal_notes' => 'boolean',
            'close_days' => 'required|integer|min:0',
            'attachment_size' => 'required|integer|min:1',
            'attachment_types' => 'required|string', // e.g., ".jpg,.pdf,.docx"
        ]);

        $settings = SystemSetting::updateOrCreate(['id' => 1], $validated);

        return response()->json(['message' => 'System settings updated', 'data' => $settings]);
    }
}
