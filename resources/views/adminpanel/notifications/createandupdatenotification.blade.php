@extends('adminpanel.layout.main')
@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notification Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Notification Form</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $notification ? 'Update Notification' : 'Add Notification' }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.notification.create.process') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <!-- Hidden ID field -->
                                <input type="hidden" name="id" value="{{ $notification->id ?? '' }}">

                                <!-- User ID -->
                                <div class="form-group">
                                    <label for="user_id">User (Optional)</label>
                                    <select name="user_id" class="form-control" id="user_id">
                                        <option value="">Select User (Global if not selected)</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $notification->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name ?? $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $notification->title ?? '') }}" placeholder="Enter title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Message -->
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea id="compose-textarea" class="form-control" style="height: 300px" name="message">{{ old('message', $notification->message ?? '') }}</textarea>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Image Upload -->
                                <div class="form-group">
                                    <label for="image">Upload Image (Optional)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                    @if($notification && $notification->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('public/upload/images/' . $notification->image) }}" width="70px" height="70px" alt="Current Image">
                                        </div>
                                    @endif
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Click Action -->
                                <div class="form-group">
                                    <label for="click_action">Click Action (Optional)</label>
                                    <input type="text" class="form-control" id="click_action" name="click_action" value="{{ old('click_action', $notification->click_action ?? '') }}" placeholder="Enter click action URL">
                                    @error('click_action')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="global" {{ old('type', $notification->type ?? 'global') == 'global' ? 'selected' : '' }}>Global</option>
                                        <option value="user_specific" {{ old('type', $notification->type ?? 'global') == 'user_specific' ? 'selected' : '' }}>User Specific</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Is Read -->
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_read" name="is_read" value="1" {{ old('is_read', $notification->is_read ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_read">Mark as Read</label>
                                    </div>
                                    @error('is_read')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ old('status', $notification->status ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.notification.list') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

@endsection