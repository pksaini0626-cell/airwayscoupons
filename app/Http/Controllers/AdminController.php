<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Admin login handler boilerplate.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.',
            ], 401);
        }

        if (!$user->is_admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Admin login successful.',
            'admin' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
            ],
        ]);
    }

    /**
     * Admin dashboard boilerplate metrics route.
     */
    public function dashboard()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_airlines' => 12,
                'active_coupons' => 48,
                'total_clicks' => 14250,
                'total_savings' => 128400,
                'admin_user' => 'admin@offersonairlines.com',
            ],
        ]);
    }
}
