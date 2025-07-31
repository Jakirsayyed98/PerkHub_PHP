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
                            <h3 class="card-title">Add / Update Games Categories</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->


                        <form action="AddOrUpdateGameCategoriesProcess" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="hidden" name="id" value="{{$records->id ?? '0'}}">
                                    <input type="name" class="form-control" value="{{$records->name ?? ''}}" name="name"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">description</label>
                                    <input type="description" class="form-control" id="" placeholder="description"
                                        value="{{$records->description  ?? ''}} " placeholder="Enter description"
                                        name="description">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">heading</label>
                                    <input type="heading" class="form-control" id="" placeholder="heading"
                                        value="{{$records->heading ?? ''}} " placeholder="Enter heading" name="heading">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">Upload Icon </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="file-upload" name="image" />
                                        </div>
                                    </div>
                                </div>



                                @if($records)
                                <img src="{{ asset('upload/images/'.$records->image) }}" width="150px"
                                    height="70px"></img>
                                @endif


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