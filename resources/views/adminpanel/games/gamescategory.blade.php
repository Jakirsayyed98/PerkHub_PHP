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
                <div class="col-sm-6 text-right">
                    <form method="get" class="d-inline">
                        <button type="submit" formaction="RefreshCategory" class="btn btn-info">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </form>
                    <a href="{{ url('AddOrUpdateGameCategories') }}" class="btn btn-success ml-2">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Name</th>
                                <th style="width: 280px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($records) && count($records) > 0)
                                @foreach($records as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <form method="get" class="d-inline">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" formaction="AddOrUpdateGameCategories" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Update
                                                </button>
                                            </form>

                                            <form method="get" class="d-inline">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" formaction="deleteGameCategory" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this category?');">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>

                                            <form method="get" class="d-inline">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" formaction="ActiveDeactiveGameCategory" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-toggle-on"></i>
                                                    {{ $item->status == '1' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No categories found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
