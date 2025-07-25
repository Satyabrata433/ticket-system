<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function getRecipients()
    {
        $roles = Role::all()->map(function ($role) {
            return [
                'type' => 'role',
                'id' => $role->id,
                'label' => $role->name,
            ];
        });

        $employees = Employee::with('role')->get()->map(function ($emp) {
            return [
                'type' => 'employee',
                'id' => $emp->id,
                'label' => "{$emp->name} ({$emp->role->name})",
            ];
        });

        return response()->json([
            'recipients' => [
                ['type' => 'all', 'id' => 'all', 'label' => 'All'],
                ...$roles,
                ...$employees
            ]
        ]);
    }
    public function sendNotification(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|string|in:all,role,employee',
            'recipient_id' => 'nullable|integer',
            'priority' => 'required|string',
            'subject' => 'required|string|max:100',
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $emails = [];

        switch ($request->recipient_type) {
            case 'all':
                $emails = Employee::pluck('email')->toArray();
                break;

            case 'role':
                if ($request->recipient_id) {
                    $emails = Employee::where('role_id', $request->recipient_id)->pluck('email')->toArray();
                }
                break;

            case 'employee':
                if ($request->recipient_id) {
                    $employee = Employee::find($request->recipient_id);
                    if ($employee) {
                        $emails[] = $employee->email;
                    }
                }
                break;
        }

        if (empty($emails)) {
            return response()->json(['message' => 'No recipients found'], 422);
        }

        foreach ($emails as $email) {
            Mail::raw($request->message, function ($message) use ($email, $request, $attachmentPath) {
                $message->to($email)
                        ->subject($request->subject);

                if ($attachmentPath) {
                    $message->attach(storage_path('app/public/' . $attachmentPath));
                }
            });
        }

        Notification::create([
            'recipient' => $request->recipient_type . ($request->recipient_id ? ':' . $request->recipient_id : ''),
            'priority' => $request->priority,
            'subject' => $request->subject,
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return response()->json(['message' => 'Notification sent successfully.']);
    }

    // // Get all notifications
    // public function index()
    // {
    //     return response()->json(Notification::all());
    // }

    // // Store a new notification
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'recipient' => 'required|string|max:50',
    //         'priority' => 'required|string|max:20',
    //         'subject' => 'required|string|max:100',
    //         'message' => 'required|string',
    //         'attachment' => 'nullable|string|max:100',
    //         'status' => 'required|string|max:20',
    //         'sent_at' => 'required|date',
    //     ]);

    //     $notification = Notification::create($request->all());

    //     return response()->json($notification, 201);
    // }

    // // Get a specific notification
    // public function show($id)
    // {
    //     $notification = Notification::find($id);

    //     if (!$notification) {
    //         return response()->json(['message' => 'Notification not found'], 404);
    //     }

    //     return response()->json($notification);
    // }

    // // Update a notification
    // public function update(Request $request, $id)
    // {
    //     $notification = Notification::find($id);

    //     if (!$notification) {
    //         return response()->json(['message' => 'Notification not found'], 404);
    //     }

    //     $notification->update($request->all());

    //     return response()->json($notification);
    // }

    // // Delete a notification
    // public function destroy($id)
    // {
    //     $notification = Notification::find($id);

    //     if (!$notification) {
    //         return response()->json(['message' => 'Notification not found'], 404);
    //     }

    //     $notification->delete();

    //     return response()->json(['message' => 'Notification deleted successfully']);
    // }
}
