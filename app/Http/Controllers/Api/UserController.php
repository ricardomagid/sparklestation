<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Handle profile picture upload (API endpoint)
     */  
    public function uploadProfile(Request $request) 
    {
        try {
            $request->validate([
                'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $user = auth()->user();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
            }

            if ($user->profile_pic && !str_contains($user->profile_pic, '..')) {
                $oldPath = public_path('images/users/' . $user->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $extension = $request->file('profile_pic')->extension();
            $filename = 'user' . $user->id . '.' . $extension;
            $request->file('profile_pic')->move(public_path('images/users'), $filename);
            $user->profile_pic = $filename;
            $user->save();

            return response()->json(['success' => true, 'path' => $user->img]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        };
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
            }

            $request -> validate([
                'username' => 'required|string|min:3|max:20|regex:/^[a-zA-Z0-9_]+$/|unique:users,username,' . $user->id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            ]);

            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            return response()->json(['success' => true]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        };
    }

    public function updateUserPreferences(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User is not authenticated'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'itemsPerPage' => 'required|integer|min:1',
            'columnsToShow' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Update user preferences
        $user->items_per_page = $validated['itemsPerPage'];
        $user->columns_to_show = $validated['columnsToShow'];
        $user->save();

        return response()->json(['success' => true, 'message' => 'Preferences updated successfully.']);
    }

    public function sendVerificationEmail(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email|exists:users,email']);

            $code = rand(100000, 999999);
            $user = User::where('email', $request->email)->first();
            $user->verification_code = $code;
            $user->verification_code_expires_at = now()->addMinutes(10);
            $user->save();

            Mail::to($request->email)->send(new VerificationCodeMail($code));

            return response()->json([
                'success' => true,
                'message' => 'Verification code sent!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please try again.'
            ], 500);
        }
    }
}