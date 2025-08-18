@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Mini App</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Mini App Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Centered column -->
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Add / Update Mini App</h3>
                        </div>

                        <!-- Form Start -->
                        <form action="{{ url('updateProcess') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <!-- Hidden ID -->
                                <input type="hidden" name="id" value="{{ $records->id ?? '0' }}">

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">App Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name"
                                           value="{{ $records->name ?? '' }}" placeholder="Enter app name" required>
                                </div>

                                <!-- Category -->
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="category_id" name="category_id" required>
                                        <option value="">Please select category</option>
                                        @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ isset($records) && $records->store_category_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- URL Type -->
                                <div class="form-group">
                                    <label for="url_type">URL Type</label>
                                    <select class="form-control select2" id="url_type" name="url_type">
                                        <option value="0" {{ empty($records) || $records->url_type == "0" ? 'selected' : '' }}>Please select</option>
                                        <option value="1" {{ isset($records) && $records->url_type == "1" ? 'selected' : '' }}>Inside</option>
                                        <option value="2" {{ isset($records) && $records->url_type == "2" ? 'selected' : '' }}>Outside</option>
                                    </select>
                                </div>

                                <!-- Affiliate Provider -->
                                <div class="form-group">
                                    <label for="macro_publisher">Affiliate Provider</label>
                                    <select class="form-control select2" id="macro_publisher" name="macro_publisher">
                                        <option value="0">Please select Provider</option>
                                        @foreach($affiliate_partner as $affiliate)
                                            <option value="{{ $affiliate->id }}" {{ isset($records) && $records->affiliate_provider_id == $affiliate->id ? 'selected' : '' }}>
                                                {{ $affiliate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Cashback Active -->
                                <div class="form-group">
                                    <label for="cb_active">Cashback Status</label>
                                    <select class="form-control select2" id="cb_active" name="cb_active">
                                        <option value="2" {{ empty($records) ? 'selected' : '' }}>Please select</option>
                                        <option value="1" {{ isset($records) && $records->cb_active == "1" ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ isset($records) && $records->cb_active == "0" ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <!-- Cashback Percentage -->
                                <div class="form-group">
                                    <label for="cb_percentage">Cashback Percentage</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" id="cb_percentage" class="form-control"
                                               name="cb_percentage" value="{{ $records->cashback ?? '' }}"
                                               placeholder="Enter cashback percentage">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" name="description" rows="3"
                                              placeholder="Write a short description">{{ $records->description ?? '' }}</textarea>
                                </div>

                                <!-- About Brand -->
                                <div class="form-group">
                                    <label for="about">About Brand</label>
                                    <input type="text" id="about" class="form-control" name="about"
                                           value="{{ $records->about_store ?? '' }}" placeholder="Enter About Brand">
                                </div>

                                <!-- How it works -->
                                <div class="form-group">
                                    <label for="work">How it works</label>
                                    <input type="text" id="work" class="form-control" name="work"
                                           value="{{ $records->how_its_work ?? '' }}" placeholder="Explain how it works">
                                </div>

                                <!-- URL -->
                                <div class="form-group">
                                    <label for="url">App URL</label>
                                    <input type="url" id="url" class="form-control" name="url"
                                           value="{{ $records->url ?? '' }}" placeholder="https://example.com">
                                </div>

                                <!-- Label -->
                                <div class="form-group">
                                    <label for="label">Label</label>
                                    <input type="text" id="label" class="form-control" name="label"
                                           value="{{ $records->label ?? '' }}" placeholder="Enter label/tag">
                                </div>

                                <!-- Upload Fields -->
                                <div class="form-group">
                                    <label>Upload Icon</label>
                                    <input type="file" name="icon" class="form-control-file" onchange="previewImage(this,'iconPreview')">
                                    <div class="mt-2">
                                        <img id="iconPreview" src="{{ $records && $records->icon ? asset('upload/images/'.$records->icon) : '' }}" 
                                             width="70" height="70" class="img-thumbnail" style="{{ isset($records->icon) ? '' : 'display:none;' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Upload Logo</label>
                                    <input type="file" name="logo" class="form-control-file" onchange="previewImage(this,'logoPreview')">
                                    <div class="mt-2">
                                        <img id="logoPreview" src="{{ $records && $records->logo ? asset('upload/images/'.$records->logo) : '' }}" 
                                             width="90" height="70" class="img-thumbnail" style="{{ isset($records->logo) ? '' : 'display:none;' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Upload Banner</label>
                                    <input type="file" name="banner" class="form-control-file" onchange="previewImage(this,'bannerPreview')">
                                    <div class="mt-2">
                                        <img id="bannerPreview" src="{{ $records && $records->banner ? asset('upload/images/'.$records->banner) : '' }}" 
                                             width="150" height="70" class="img-thumbnail" style="{{ isset($records->banner) ? '' : 'display:none;' }}">
                                    </div>
                                </div>

                                <!-- Cashback Terms -->
                                <div class="form-group">
                                    <label for="cashback_terms">Cashback Terms</label>
                                    <textarea id="cashback_terms" class="form-control" name="cashback_terms" rows="4"
                                              placeholder="Enter cashback terms">{{ $records->terms_and_conditions ?? '' }}</textarea>
                                </div>

                            </div>

                            <!-- Submit -->
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Save</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(input, previewId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection
