@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1>{{ $notification ? 'Update Notification' : 'Add Notification' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Notification Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-md-8">
                    <div class="card card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bell"></i> {{ $notification ? 'Update Notification' : 'Create Notification' }}
                            </h3>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('admin.notification.create.process') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $notification->id ?? '' }}">

                            <div class="card-body">

                                <!-- User -->
                                <div class="form-group">
                                    <label for="user_id">Send To (Optional)</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">All Users (Global)</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $notification->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name ?? $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           value="{{ old('title', $notification->title ?? '') }}"
                                           placeholder="Enter notification title">
                                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Message -->
                                <div class="form-group">
                                    <label for="message">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" id="compose-textarea" class="form-control" style="height:200px"
                                              placeholder="Enter your notification message...">{{ old('message', $notification->message ?? '') }}</textarea>
                                    @error('message') <span class="text-danger">{{ $message }}</span> @enderror
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
                                            <img src="{{ asset('public/upload/images/' . $notification->image) }}" width="80" height="80" class="img-thumbnail">
                                        </div>
                                    @endif
                                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Click Action -->
                                <div class="form-group">
                                    <label for="click_action">Click Action URL (Optional)</label>
                                    <input type="text" name="click_action" id="click_action" class="form-control"
                                           value="{{ old('click_action', $notification->click_action ?? '') }}"
                                           placeholder="https://example.com/page">
                                    @error('click_action') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Type -->
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="global" {{ old('type', $notification->type ?? 'global') == 'global' ? 'selected' : '' }}>Global</option>
                                        <option value="user_specific" {{ old('type', $notification->type ?? '') == 'user_specific' ? 'selected' : '' }}>User Specific</option>
                                    </select>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Checkboxes -->
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="is_read" name="is_read" value="1" {{ old('is_read', $notification->is_read ?? false) ? 'checked' : '' }}>
                                        <label for="is_read">Mark as Read</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="status" name="status" value="1" {{ old('status', $notification->status ?? true) ? 'checked' : '' }}>
                                        <label for="status">Active</label>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <a href="{{ route('admin.notification.list') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection
