@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ isset($records) ? 'Update' : 'Add' }} Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($records) ? 'Update' : 'Add' }} Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Form -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($records) ? 'Update' : 'Add' }} Category</h3>
                        </div>

                        <div class="card-body">
                            <form action="AddOrUpdateCategoriesProcess" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $records->id ?? 0 }}">

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="category-name">Name</label>
                                    <input type="text" class="form-control" id="category-name" name="name"
                                        placeholder="Enter category name" value="{{ $records->name ?? '' }}" required>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="category-description">Description</label>
                                    <textarea class="form-control" id="category-description" name="description" rows="3"
                                        placeholder="Enter description">{{ $records->description ?? '' }}</textarea>
                                </div>

                                <!-- Image Upload -->
                                <div class="form-group">
                                    <label for="file-upload">Upload Icon</label>
                                    <input type="file" class="form-control-file" id="file-upload" name="image" accept="image/*">
                                </div>

                                <!-- Image Preview -->
                                <div class="form-group text-center">
                                    <img id="preview-image" 
                                        src="{{ isset($records->image) ? asset('upload/images/'.$records->image) : '' }}"
                                        class="{{ isset($records->image) ? '' : 'd-none' }} img-fluid rounded shadow-sm"
                                        style="max-width:200px; max-height:120px; object-fit:cover;">
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> {{ isset($records) ? 'Update' : 'Submit' }}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file-upload');
    const preview = document.getElementById('preview-image');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if(file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    });
});
</script>
@endsection
