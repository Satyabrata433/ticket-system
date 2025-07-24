<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function requestOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check rate limit
        $recentOtps = DB::table('otp_requests')
            ->where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subHour())
            ->count();

        if ($recentOtps >= 3) {
            return response()->json(['message' => 'Too many OTP requests. Try again later.'], 429);
        }

        // Generate 6-digit OTP
        $otpCode = sprintf("%06d", mt_rand(0, 999999));

        // Store OTP in otp_requests table
        try {
            DB::table('otp_requests')->insert([
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'expires_at' => Carbon::now()->addMinutes(10),
                'is_used' => false,
                'created_at' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to generate OTP', 'error' => $e->getMessage()], 500);
        }

        // Send OTP via email
        try {
            Mail::to($user->email)->send(new OtpMail($otpCode));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send OTP', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OTP sent to your email']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $otp = DB::table('otp_requests')
            ->where('user_id', $user->id)
            ->where('otp_code', $request->otp)
            ->where('is_used', false)
            ->where('expires_at', '>=', Carbon::now())
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'Invalid or expired OTP'], 401);
        }

        // Mark OTP as used
        try {
            DB::table('otp_requests')
                ->where('id', $otp->id)
                ->update(['is_used' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to process OTP', 'error' => $e->getMessage()], 500);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}