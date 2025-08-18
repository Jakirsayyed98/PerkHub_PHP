@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Game Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            {{ isset($records) && $records->id ? 'Update Category' : 'Add New Category' }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">

                    <!-- Card -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-gamepad"></i>
                                {{ isset($records) && $records->id ? 'Update Game Category' : 'Add New Game Category' }}
                            </h3>
                        </div>

                        <form action="{{ url('AddOrUpdateGameCategoriesProcess') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $records->id ?? 0 }}">

                            <div class="card-body">

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name"
                                           value="{{ $records->name ?? '' }}" placeholder="Enter category name" required>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" rows="3" name="description"
                                              placeholder="Enter description">{{ $records->description ?? '' }}</textarea>
                                </div>

                                <!-- Heading -->
                                <div class="form-group">
                                    <label for="heading">Heading</label>
                                    <input type="text" id="heading" class="form-control" name="heading"
                                           value="{{ $records->heading ?? '' }}" placeholder="Enter heading">
                                </div>

                                <!-- Image Upload -->
                                <div class="form-group">
                                    <label for="file-upload">Upload Icon</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file-upload" name="image"
                                               accept="image/*" onchange="previewImage(event)">
                                        <label class="custom-file-label" for="file-upload">Choose file</label>
                                    </div>

                                    <!-- Preview -->
                                    <div class="mt-3">
                                        <img id="preview"
                                             src="{{ isset($records->image) ? asset('upload/images/'.$records->image) : '' }}"
                                             class="img-fluid img-thumbnail shadow-sm"
                                             style="max-width:150px; height:auto; {{ isset($records->image) ? '' : 'display:none;' }}">
                                    </div>
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <a href="{{ url('GameCategoriesList') }}" class="btn btn-secondary px-4 ml-2">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(event) {
        let preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = "block";
        preview.onload = function () {
            URL.revokeObjectURL(preview.src);
        }
    }
</script>

@endsection
