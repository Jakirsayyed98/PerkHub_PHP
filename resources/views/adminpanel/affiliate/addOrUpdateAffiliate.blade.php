@extends('adminpanel.layout.main')
@section('main-container')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Banner Add and Update Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Banner Add and Update Form</li>
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
                            <h3 class="card-title">Add and Update Affiliate</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->


                        <form action="AffiliateAddOrUpdateProcess" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="hidden" name="id" value="{{$data->id ?? '0'}}">
                                    <input type="name" class="form-control" value="{{$data->name ?? ''}}" name="name"
                                        placeholder="Enter name">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPassword1">Base Url</label>
                                    <input type="base_url" class="form-control" id="" name="base_url" placeholder="base_url"
                                        value="{{$data->base_url ?? ''}} " placeholder="Enter Url" name="base_url">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Callback Secret</label>
                                    <input type="callback_secret" class="form-control" id="" name="callback_secret" placeholder="callback_secret"
                                        value="{{$data->callback_secret ?? ''}} " placeholder="Enter Url" name="callback_secret">
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