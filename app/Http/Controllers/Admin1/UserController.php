<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');

        $query = User::select('id', 'uuid', 'name', 'email', 'mobile', 'gender', 'dob', 'created_at')
            ->withCount(['orders', 'withdrawalRequests', 'supportTickets']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return ApiResponse::success($users, 'Users retrieved successfully');
    }

    public function show(Request $request, $id)
    {
        $user = User::select('id', 'uuid', 'name', 'email', 'mobile', 'gender', 'dob', 'created_at')
            ->withCount(['orders', 'withdrawalRequests', 'supportTickets'])
            ->find($id);

        if (!$user) {
            return ApiResponse::error('User not found', [], 404, 'USER_NOT_FOUND');
        }

        return ApiResponse::success($user, 'User details retrieved successfully');
    }
}