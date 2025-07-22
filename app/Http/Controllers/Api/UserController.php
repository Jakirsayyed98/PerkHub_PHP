<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Update authenticated user's profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|digits:10|unique:users,mobile,' . $user->id,
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validation failed',
                $validator->errors(),
                422,
                'VALIDATION_FAILED'
            );
        }

        $data = $request->only(['name', 'email', 'mobile']);
        $updatedUser = User::updateProfile($user->id, $data);

        if (!$updatedUser) {
            return ApiResponse::error(
                'Failed to update profile',
                [],
                500,
                'PROFILE_UPDATE_FAILED'
            );
        }

        return ApiResponse::success(
            $updatedUser,
            'Profile updated successfully'
        );
    }

    /**
     * List users (for Admin Panel)
     */
    public function listUsers(Request $request)
    {
        $perPage = $request->input('per_page', 20); // Default 20 users per page
        $users = User::getUsers($perPage);

        return ApiResponse::success(
            $users,
            'Users retrieved successfully'
        );
    }

    /**
     * Show specific user details (for Admin Panel)
     */
    public function showUser(Request $request, $id)
    {
        $user = User::getUserById($id);

        if (!$user) {
            return ApiResponse::error(
                'User not found',
                [],
                404,
                'USER_NOT_FOUND'
            );
        }

        return ApiResponse::success(
            $user,
            'User details retrieved successfully'
        );
    }
}