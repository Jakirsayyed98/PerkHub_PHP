@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">MiniApp Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <form action="AddOrUpdateCategories" method="get" class="d-inline">
                            <input type="hidden" name="id" value="0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New
                            </button>
                        </form>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Table -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Manage Categories</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Homepage</th>
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
                                                        <img src="{{ asset('upload/images/'.$item->image) }}"
                                                            class="img-fluid rounded shadow-sm"
                                                            style="max-width:70px; height:70px; object-fit:cover;">
                                                    </td>
                                                    <td>{{ $item->description }}</td>
                                                    <td>
                                                        @if($item->status == '1')
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->homepage_visible == '1')
                                                            <span class="badge badge-success">Visible</span>
                                                        @else
                                                            <span class="badge badge-secondary">Hidden</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form method="get" class="d-inline">
                                                            <input type="hidden" name="category_id" value="{{ $item->id }}">

                                                            <!-- Update -->
                                                            <button type="submit" formaction="AddOrUpdateCategories" class="btn btn-sm btn-info">
                                                                <i class="fas fa-edit"></i> Update
                                                            </button>

                                                            <!-- Delete -->
                                                            <button type="submit" formaction="DeleteCategorie" class="btn btn-sm btn-danger ml-1"
                                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>

                                                            <!-- Toggle Active -->
                                                            <button type="submit" formaction="ActiveDeactive" class="btn btn-sm btn-warning ml-1">
                                                                <i class="fas fa-toggle-{{ $item->status == '1' ? 'off' : 'on' }}"></i>
                                                                {{ $item->status == '1' ? 'Deactivate' : 'Activate' }}
                                                            </button>

                                                            <!-- Toggle Homepage -->
                                                            <button type="submit" formaction="ActiveDeactivehomePageVis" class="btn btn-sm btn-secondary ml-1">
                                                                <i class="fas fa-home"></i>
                                                                {{ $item->homepage_visible == '1' ? 'Hide' : 'Show' }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No categories found.</td>
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
            <!-- /.row -->
        </div>
    </section>

</div>
@endsection
