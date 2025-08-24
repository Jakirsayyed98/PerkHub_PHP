@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Banner Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Add / Update Banner</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <!-- Banner Form -->
                    <div class="card card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-image"></i>
                                {{ isset($records) ? 'Update Banner in Banner ' . ($records->banner_id ?? '') : 'Add New Banner' }}
                            </h3>
                        </div>

                        <form action="{{ url('AddOrUpdateBannerProcess') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <!-- Hidden Fields -->
                                <input type="hidden" name="id" value="{{ $records->id ?? '0' }}">
                                <input type="hidden" name="banner_type" value="{{ $bannerType ?? '0' }}">

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="bannerName">Banner Name {{ $bannerType }}<span class="text-danger">*</span></label>
                                    <input type="text" id="bannerName" class="form-control" name="name"
                                           value="{{ $records->name ?? '' }}" placeholder="Enter banner name" required>
                                </div>

                                <!-- URL -->
                                <div class="form-group">
                                    <label for="bannerUrl">Banner URL</label>
                                    <input type="url" id="bannerUrl" class="form-control" name="url"
                                           value="{{ $records->url ?? '' }}" placeholder="Enter redirect URL">
                                </div>

                                <!-- File Upload -->
                                <div class="form-group">
                                    <label for="bannerImage">Upload Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="bannerImage" name="image" accept="image/*">
                                        <label class="custom-file-label" for="bannerImage">Choose file</label>
                                    </div>
                                </div>

                                <!-- Preview (Existing or New) -->
                                <div class="mt-3">
                                    <p>Preview:</p>
                                    <img id="previewImage"
                                         src="{{ !empty($records->image) ? asset('upload/images/'.$records->image) : 'https://via.placeholder.com/200x100?text=No+Image' }}"
                                         class="img-fluid img-thumbnail"
                                         style="max-width: 200px; height: auto;">
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> {{ isset($records) ? 'Update' : 'Save' }}
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </form>

                        <!-- 🔹 Image Preview Script -->
                        <script>
                        document.getElementById('bannerImage').addEventListener('change', function(event) {
                            const fileInput = event.target;
                            const [file] = fileInput.files;

                            // Update preview when a new file is chosen
                            if (file) {
                                document.getElementById('previewImage').src = URL.createObjectURL(file);
                            }

                            // Update the label text
                            const label = fileInput.nextElementSibling;
                            if (label && file) {
                                label.innerText = file.name;
                            }
                        });
                        </script>

                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>

@endsection
