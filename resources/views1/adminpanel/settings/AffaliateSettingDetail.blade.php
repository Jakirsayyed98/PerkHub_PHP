@extends('adminpanel.layout.main')
@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>General Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">General Form</li>
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
                            <h3 class="card-title">Add / Update</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <!-- enctype="multipart/form-data" -->

                        <form action="CommisionSettingAddOrUpdateProcess" method="get" >
                            @csrf
                            <div class="card-body">


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="hidden" name="id" value="{{$records->id ?? '0'}}">
                                    <input type="name" class="form-control" value="{{$records->Affiliate_name ?? ''}}" name="Affiliate_name"
                                        placeholder="Enter name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">User Commision Percentage</label>
                                    <input type="name" class="form-control" value="{{$records->user_commision ?? ''}}" name="user_commision"
                                        placeholder="Enter User Commision Percentage">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">API KEY</label>
                                    <input type="name" class="form-control" value="{{$records->API_KEY ?? ''}}" name="API_KEY"
                                        placeholder="Enter API KEY">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Channel Name</label>
                                    <input type="name" class="form-control" value="{{$records->channel_name ?? ''}}" name="channel_name"
                                        placeholder="Enter Channel Name">
                                </div>


                                <!-- /.form-group -->
                                
                                <div class="form-group">
                                    <label>Select status type</label>
                                    <select class="form-control select2" style="width: 100%;" name="status">

                                        @if($records)
                                        @if($records->status=="0")
                                        <option value="0" selected="selected">Deactive</option>
                                        <option value="1">Active</option>

                                        @elseif($records->status=="1")
                                        <option value="0">Deactive</option>
                                        <option value="1" selected="selected">Active</option>

                                        @else
                                        <option value="2" selected="selected">Please select  active type</option>
                                        <option value="0">Deactive</option>
                                        <option value="1">Active</option>
                                        @endif

                                        @else
                                        <option value="2" selected="selected">Please select  active type</option>
                                        <option value="0">Deactive</option>
                                        <option value="1">Active</option>
                                        @endif

                                    </select>
                                </div> 
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>





                    </div>
                    <!-- /.card -->


                    <!-- /.card -->

                </div>
                <!--/.col (left) -->
                <!-- right column -->

                <!--/.col (right) -->
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
</div>

<!-- ./wrapper -->

@endsection