@extends('adminpanel.layout.main')
@section('main-container')


@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif



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
                       
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User ID</th>
                                        <th>Requested Amount</th>
                                        <th>Requested Date</th>
                                        <th>Transaction Id</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($records as $item)

                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->user_id}}</td>
                                        <td>₹{{$item->requested_withdrawal_amt}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->txn_id}}</td>

                                        @if($item->status == '0')
                                        <td>Pending</td>
                                        @elseif($item->status == '1')
                                        <td>Verified</td>
                                        @else
                                        <td>Rejected</td>
                                        @endif


                                        @if($item->status == '0')
                                        <form method="get">
                                            <td>
                                                <button type="submit" formaction="withdrawalstatusupdate"
                                                    class="btn btn-primary" name="id"
                                                    value="{{$item->id}}">Update</button>
                                            </td>
                                        </form>
                                        @endif
                                        

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