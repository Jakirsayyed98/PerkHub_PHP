<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\AffiliateProvider;
use Illuminate\Support\Facades\Validator;

class AffiliateProviderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');
        $status = $request->input('status');

        $query = AffiliateProvider::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        $providers = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return ApiResponse::success($providers, 'Affiliate providers retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:affiliate_providers',
            'base_url' => 'required|url',
            'callback_secret' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422, 'VALIDATION_FAILED');
        }

        $provider = AffiliateProvider::create([
            'name' => $request->name,
            'base_url' => $request->base_url,
            'callback_secret' => $request->callback_secret,
            'status' => $request->status,
        ]);

        return ApiResponse::success($provider, 'Affiliate provider created successfully');
    }

    public function update(Request $request, $id)
    {
        $provider = AffiliateProvider::find($id);
        if (!$provider) {
            return ApiResponse::error('Affiliate provider not found', [], 404, 'PROVIDER_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:affiliate_providers,name,' . $id,
            'base_url' => 'required|url',
            'callback_secret' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422, 'VALIDATION_FAILED');
        }

        $provider->update([
            'name' => $request->name,
            'base_url' => $request->base_url,
            'callback_secret' => $request->callback_secret,
            'status' => $request->status,
        ]);

        return ApiResponse::success($provider, 'Affiliate provider updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $provider = AffiliateProvider::find($id);
        if (!$provider) {
            return ApiResponse::error('Affiliate provider not found', [], 404, 'PROVIDER_NOT_FOUND');
        }

        $provider->delete();
        return ApiResponse::success(null, 'Affiliate provider deleted successfully');
    }
}