<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    //
    public function index()
    {
        return Partner::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:100',
            'email' => 'required|email|unique:partners,email',
            'address' => 'required|string',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'status' => 'required|in:Active,Inactive,Pending',
            'contact_person_name' => 'required|string|max:100',
            'contact_person_mobile' => 'required|string|max:15',
        ]);

        $partner = Partner::create($validated);

        return response()->json(['message' => 'Partner created', 'data' => $partner], 201);
    }

    public function show($id)
    {
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['message' => 'Partner not found'], 404);
        }

        return response()->json($partner);
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'business_name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:partners,email,' . $id,
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string|max:50',
            'state' => 'sometimes|required|string|max:50',
            'status' => 'sometimes|required|in:Active,Inactive',
            'contact_person_name' => 'sometimes|required|string|max:100',
            'contact_person_mobile' => 'sometimes|required|string|max:15',
        ]);

        $partner->update($validated);

        return response()->json(['message' => 'Partner updated', 'data' => $partner]);
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return response()->json(['message' => 'Partner deleted']);
    }
}
