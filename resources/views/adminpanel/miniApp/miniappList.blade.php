@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <center>
        <h1>MiniApp List</h1>
    </center>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DataTables</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <form action="{{ url('ExportExcel') }}" method="get" style="display:inline;">
                            <button type="submit" class="btn btn-info btn-sm" name="id" value="0" style="margin-right:10px;">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                        </form>

                        <form action="{{ url('UpdateMiniApp') }}" method="get" style="display:inline;">
                            <button type="submit" class="btn btn-success btn-sm" name="id" value="0">
                                <i class="fas fa-plus-circle"></i> Add New
                            </button>
                        </form>

                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Popular</th>
                                        <th>Trending</th>
                                        <th>Top Cashback</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @if(isset($records))
                                    @foreach($records as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td style="width:200px">{{ $item->name }}</td>
                                           
                                            <td>
                                                <form method="get" action="{{ url('popularActiveDeactive') }}">
                                                    <button class="btn btn-sm {{ $item->popular == '1' ? 'btn-danger' : 'btn-warning' }}" 
                                                            type="submit" name="id" value="{{ $item->id }}">
                                                        {{ $item->popular == '1' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="get" action="{{ url('trendingActiveDeactive') }}">
                                                    <button class="btn btn-sm {{ $item->trending == '1' ? 'btn-danger' : 'btn-warning' }}" 
                                                            type="submit" name="id" value="{{ $item->id }}">
                                                        {{ $item->trending == '1' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="get" action="{{ url('top_cashbackActiveDeactive') }}">
                                                    <button class="btn btn-sm {{ $item->top_cashback == '1' ? 'btn-danger' : 'btn-warning' }}" 
                                                            type="submit" name="id" value="{{ $item->id }}">
                                                        {{ $item->top_cashback == '1' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                 <form method="get" action="{{ url('miniAppActiveDeactive') }}" style="display:inline;">
                                                    <button class="btn btn-sm {{ $item->status == '1' ? 'btn-danger' : 'btn-success' }}" 
                                                            type="submit" name="id" value="{{ $item->id }}">
                                                        {{ $item->status == '1' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </td>

                                            <td>
                                                <form method="get" action="{{ url('UpdateMiniApp') }}" style="display:inline;">
                                                    <button class="btn btn-primary btn-sm" type="submit" name="id" value="{{ $item->id }}">
                                                        <i class="fas fa-edit"></i> Update
                                                    </button>
                                                </form>

                                                <form method="get" action="{{ url('deleteProcess') }}" style="display:inline;">
                                                    <button class="btn btn-danger btn-sm" type="submit" name="id" value="{{ $item->id }}">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>

                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>

                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
