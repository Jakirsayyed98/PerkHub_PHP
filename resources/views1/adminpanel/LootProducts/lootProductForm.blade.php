@extends('adminpanel.layout.main')

@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h1>{{ isset($records) ? 'Edit' : 'Add' }} Loot Product</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Product Form</h3>
                        </div>

                        <form action="AddOrUpdateLootProductProcess" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $records->id ?? 0 }}">

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $records->product_name ?? '') }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description', $records->description ?? '') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Image URL</label>
                                    <input type="text" name="image_url" class="form-control" value="{{ old('image_url', $records->image_url ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Product URL</label>
                                    <input type="text" name="product_url" class="form-control" value="{{ old('product_url', $records->product_url ?? '') }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Original Price</label>
                                    <input type="number" step="0.01" name="original_price" class="form-control" value="{{ old('original_price', $records->original_price ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Discounted Price</label>
                                    <input type="number" step="0.01" name="discounted_price" class="form-control" value="{{ old('discounted_price', $records->discounted_price ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Discount Percentage</label>
                                    <input type="number" step="0.01" name="discount_percentage" class="form-control" value="{{ old('discount_percentage', $records->discount_percentage ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Coupon Code</label>
                                    <input type="text" name="coupon_code" class="form-control" value="{{ old('coupon_code', $records->coupon_code ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Offer Type</label>
                                    <select name="offer_type" class="form-control">
                                        <option value="0" {{ (old('offer_type', $records->offer_type ?? 0) == 0) ? 'selected' : '' }}>Offer</option>
                                        <option value="1" {{ (old('offer_type', $records->offer_type ?? 0) == 1) ? 'selected' : '' }}>Coupon</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ (old('status', $records->status ?? 1) == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('status', $records->status ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Offer Expiry Date</label>
                                    <input type="date" name="offer_expiry" class="form-control" value="{{ old('offer_expiry', isset($records->offer_expiry) ? $records->offer_expiry : '') }}">
                                    <!-- <input type="date" name="offer_expiry" class="form-control" value="{{ old('offer_expiry', isset($records->offer_expiry) ? $records->offer_expiry->format('Y-m-d') : '') }}"> -->
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ isset($records) ? 'Update' : 'Add' }} Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
