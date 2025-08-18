@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        Banners List <span class="text-primary">#{{ $banner_id }}</span>
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <form method="get" class="d-inline">
                        <input type="hidden" name="id" value="0">
                        <input type="hidden" name="banner_id" value="{{ $banner_id }}">
                        <button type="submit" formaction="AddAndUpdateBanner" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Table -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Manage Banners</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th style="width: 240px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($records) && $records->count() > 0)
                                            @foreach($records as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td class="text-center">
                                                        <img src="{{ $item->image }}"
                                                             class="img-fluid rounded shadow-sm"
                                                             style="max-width: 120px; height:70px; object-fit:cover;">
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $item->status == '1' ? 'success' : 'secondary' }}">
                                                            {{ $item->status == '1' ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <form method="get" class="d-inline">
                                                            <input type="hidden" name="banner_id" value="{{ $banner_id }}">
                                                            <input type="hidden" name="id" value="{{ $item->id }}">

                                                            <!-- Update -->
                                                            <button type="submit" formaction="AddAndUpdateBanner"
                                                                    class="btn btn-sm btn-info">
                                                                <i class="fas fa-edit"></i> Update
                                                            </button>

                                                            <!-- Delete -->
                                                            <button type="submit" formaction="deleteBanner"
                                                                    class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this banner?')">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>

                                                            <!-- Active/Deactive -->
                                                            <button type="submit" formaction="ActiveDeactivebanner"
                                                                    class="btn btn-sm btn-warning">
                                                                <i class="fas fa-toggle-{{ $item->status == '1' ? 'off' : 'on' }}"></i>
                                                                {{ $item->status == '1' ? 'Deactivate' : 'Activate' }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">
                                                    No banners found.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>

</div>
@endsection
