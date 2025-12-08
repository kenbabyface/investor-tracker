<?php

namespace App\Http\Controllers;

use App\Models\AdminSetting;
use Illuminate\Http\Request;

class AdminPasswordController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if (AdminSetting::verifyPassword($request->password)) {
            session([
                'admin_verified' => true, 
                'admin_verified_at' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Password verified successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Incorrect password'
        ], 401);
    }

    
    public function showSettings()
    {
        return view('admin.settings');
    }

    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!AdminSetting::verifyPassword($request->current_password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        AdminSetting::updatePassword($request->new_password);

        return back()->with('success', 'Admin password updated successfully!');
    }

    public static function isVerified()
    {
        if (!session('admin_verified')) {
            return false;
        }

        $verifiedAt = session('admin_verified_at');
        if ($verifiedAt && now()->diffInMinutes($verifiedAt) > 5) {
            session()->forget(['admin_verified', 'admin_verified_at']);
            return false;
        }

        return true;
    }
}