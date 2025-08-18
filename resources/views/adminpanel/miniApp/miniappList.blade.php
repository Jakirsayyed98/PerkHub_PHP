@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">MiniApp List</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <form action="{{ url('ExportExcel') }}" method="get" class="d-inline">
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </form>
                    <a href="{{ url('UpdateMiniApp') }}" class="btn btn-success btn-sm ml-2">
                        <i class="fas fa-plus-circle"></i> Add New
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Popular</th>
                                <th>Trending</th>
                                <th>Top Cashback</th>
                                <th>Status</th>
                                <th style="width: 250px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($records) && count($records) > 0)
                                @foreach($records as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td style="width:200px">{{ $item->name }}</td>

                                        <!-- Popular -->
                                        <td>
                                            <form method="get" action="{{ url('popularActiveDeactive') }}">
                                                <button class="btn btn-sm {{ $item->popular == '1' ? 'btn-danger' : 'btn-warning' }}" 
                                                        type="submit" name="id" value="{{ $item->id }}">
                                                    <i class="fas fa-star"></i> {{ $item->popular == '1' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Trending -->
                                        <td>
                                            <form method="get" action="{{ url('trendingActiveDeactive') }}">
                                                <button class="btn btn-sm {{ $item->trending == '1' ? 'btn-danger' : 'btn-info' }}" 
                                                        type="submit" name="id" value="{{ $item->id }}">
                                                    <i class="fas fa-fire"></i> {{ $item->trending == '1' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Top Cashback -->
                                        <td>
                                            <form method="get" action="{{ url('top_cashbackActiveDeactive') }}">
                                                <button class="btn btn-sm {{ $item->top_cashback == '1' ? 'btn-danger' : 'btn-success' }}" 
                                                        type="submit" name="id" value="{{ $item->id }}">
                                                    <i class="fas fa-coins"></i> {{ $item->top_cashback == '1' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            <form method="get" action="{{ url('miniAppActiveDeactive') }}">
                                                <button class="btn btn-sm {{ $item->status == '1' ? 'btn-danger' : 'btn-success' }}" 
                                                        type="submit" name="id" value="{{ $item->id }}">
                                                    <i class="fas fa-toggle-{{ $item->status == '1' ? 'off' : 'on' }}"></i>
                                                    {{ $item->status == '1' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <form method="get" action="{{ url('UpdateMiniApp') }}" class="d-inline">
                                                <button class="btn btn-primary btn-sm" type="submit" name="id" value="{{ $item->id }}">
                                                    <i class="fas fa-edit"></i> Update
                                                </button>
                                            </form>

                                            <form method="get" action="{{ url('deleteProcess') }}" class="d-inline">
                                                <button class="btn btn-danger btn-sm" type="submit" name="id" value="{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No MiniApps found.</td>
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
