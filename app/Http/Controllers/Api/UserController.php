<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|digits:10|unique:users,mobile,' . $user->id,
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date|before:today',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validation failed',
                $validator->errors(),
                422,
                'VALIDATION_FAILED'
            );
        }

        $data = $request->only(['name', 'email', 'mobile', 'gender', 'dob']);
        $user->update($data);

        return ApiResponse::success(
            $user,
            'Profile updated successfully'
        );
    }

    public function listUsers(Request $request)
    {
        $perPage = $request->input('per_page', 20);

        $users = User::query()
            ->select('id', 'uuid', 'name', 'email', 'mobile', 'gender', 'dob', 'created_at')
            ->paginate($perPage);

        return ApiResponse::success(
            $users,
            'Users retrieved successfully'
        );
    }

    public function showUser(Request $request, $id)
    {
        $user = User::where('id', $id)
            ->select('id', 'uuid', 'name', 'email', 'mobile', 'gender', 'dob', 'created_at')
            ->first();

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