<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Store;
use App\Models\AffiliateProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Store::with(['affiliateProvider' => function ($query) {
            $query->select('id', 'name', 'base_url', 'status');
        }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('label', 'like', "%{$search}%")
                  ->orWhere('about_store', 'like', "%{$search}%");
            });
        }

        if ($status !== null) {
            $query->where('active', $status);
        }

        $stores = $query->orderBy('created_at', 'desc')
            ->withTrashed()
            ->paginate($perPage)
            ->through(function ($store) {
                $store->cashback = (float) $store->cashback;
                return $store;
            });

        return ApiResponse::success($stores, 'Stores retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'affiliate_provider_id' => 'required|exists:affiliate_providers,id',
            'icon' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
            'banner' => 'nullable|string|max:255',
            'about_store' => 'nullable|string|max:2000',
            'terms_and_conditions' => 'nullable|string|max:2000',
            'label' => 'nullable|string|max:50',
            'cashback' => 'required|numeric|min:0',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422, 'VALIDATION_FAILED');
        }

        $store = Store::create([
            'name' => $request->name,
            'affiliate_provider_id' => $request->affiliate_provider_id,
            'icon' => $request->icon,
            'logo' => $request->logo,
            'banner' => $request->banner,
            'about_store' => $request->about_store,
            'terms_and_conditions' => $request->terms_and_conditions,
            'label' => $request->label,
            'cashback' => $request->cashback,
            'active' => $request->active,
            'added_by_admin_id' => Auth::id(),
        ]);

        return ApiResponse::success($store, 'Store created successfully');
    }

    public function update(Request $request, $id)
    {
        $store = Store::withTrashed()->find($id);
        if (!$store) {
            return ApiResponse::error('Store not found', [], 404, 'STORE_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'affiliate_provider_id' => 'required|exists:affiliate_providers,id',
            'icon' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
            'banner' => 'nullable|string|max:255',
            'about_store' => 'nullable|string|max:2000',
            'terms_and_conditions' => 'nullable|string|max:2000',
            'label' => 'nullable|string|max:50',
            'cashback' => 'required|numeric|min:0',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422, 'VALIDATION_FAILED');
        }

        $store->update([
            'name' => $request->name,
            'affiliate_provider_id' => $request->affiliate_provider_id,
            'icon' => $request->icon,
            'logo' => $request->logo,
            'banner' => $request->banner,
            'about_store' => $request->about_store,
            'terms_and_conditions' => $request->terms_and_conditions,
            'label' => $request->label,
            'cashback' => $request->cashback,
            'active' => $request->active,
            'added_by_admin_id' => Auth::id(),
        ]);

        return ApiResponse::success($store, 'Store updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $store = Store::find($id);
        if (!$store) {
            return ApiResponse::error('Store not found', [], 404, 'STORE_NOT_FOUND');
        }

        $store->update(['deleted_by_admin_id' => Auth::id()]);
        $store->delete();

        return ApiResponse::success(null, 'Store deleted successfully');
    }
}