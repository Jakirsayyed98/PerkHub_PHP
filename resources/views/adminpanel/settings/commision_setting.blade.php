@extends('adminpanel.layout.main')
@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DataTables</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">DataTables</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <ol class="breadcrumb float-sm-left">
                                <form action="UploadTxn" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="excel_file">
                                    <button type="submit">Import</button>
                                </form>

                                <form method="get">
                                    <td>
                                        <button type="submit" formaction="BulkMiniAppTxn" class="btn btn-primary"
                                            style="margin-left:15px;" name="id" value="">Export Excel</button>
                                    </td>
                                </form>

                                <form method="get">
                                    <td>
                                        <button type="submit" formaction="CommisionSettingAddOrUpdate"
                                            class="btn btn-primary" style="margin-left:15px;" name="id" value="">+ Add
                                            new</button>
                                    </td>
                                </form>
                            </ol>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Affiliate Name</th>
                                        <th>User Commission</th>
                                        <th>API KEY</th>
                                        <th>Channel Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($records as $item)

                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->Affiliate_name}}</td>
                                        <td>{{$item->user_commision}}</td>
                                        <td>{{$item->API_KEY}}</td>
                                        <td>{{$item->channel_name}}</td>

                                        @if($item->status == '0')
                                        <td>Deactive</td>
                                        @else
                                        <td>Active</td>
                                        @endif


                                        <form method="get">
                                            <td>
                                                <button type="submit" formaction="CommisionSettingAddOrUpdate"
                                                    class="btn btn-primary" name="id"
                                                    value="{{$item->id}}">Update</button>
                                            </td>
                                        </form>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection