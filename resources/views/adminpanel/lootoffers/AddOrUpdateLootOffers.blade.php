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


                        <form action="updateLootOfferProcess" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="hidden" name="id" value="{{$records->id ?? '0'}}">
                                    <input type="name" class="form-control" value="{{$records->title ?? ''}}"
                                        name="title" placeholder="Enter Title">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Description</label>
                                    <input type="name" class="form-control" value="{{$records->description ?? ''}}"
                                        name="description" placeholder="Enter Description">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">price</label>
                                    <input type="name" class="form-control" value="{{$records->price ?? ''}}"
                                        name="price" placeholder="Enter price">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">dis_price</label>
                                    <input type="name" class="form-control" value="{{$records->dis_price ?? ''}}"
                                        name="dis_price" placeholder="Enter Discounted price">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Image Url</label>
                                    <input type="image_url" class="form-control"  value="{{$records->image ?? ''}}"
                                        name="image_url" placeholder="Enter Image Url">
                                </div>

                                @if($records)
                                <img src="{{ $records->image ?? '' }}" width="70px"
                                    height="70px"></img>
                                @endif


                                <div class="form-group">
                                    <label for="exampleInputEmail1">url</label>
                                    <input type="name" class="form-control" value="{{$records->url ?? ''}}" name="url"
                                        placeholder="Enter Url">
                                </div>


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
                                        <option value="2" selected="selected">Please select active type</option>
                                        <option value="0">Deactive</option>
                                        <option value="1">Active</option>
                                        @endif
                                        @else
                                        <option value="2" selected="selected">Please select active type</option>
                                        <option value="0">Deactive</option>
                                        <option value="1">Active</option>
                                        @endif

                                    </select>

                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">end_date</label>
                                    <input type="date" class="form-control" value="{{$records->end_date ?? ''}}"
                                        name="end_date" placeholder="Enter End Date">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">coupon_code</label>
                                    <input type="name" class="form-control" value="{{$records->coupon_code ?? ''}}"
                                        name="coupon_code" placeholder="Enter coupon code">
                                </div>


                                <div class="form-group">
                                    <label>Select Coupon required or not type</label>
                                    <select class="form-control select2" style="width: 100%;" name="coupon_status">

                                        @if($records)
                                        @if($records->coupon_status=="0")
                                        <option value="0" selected="selected">Not Required</option>
                                        <option value="1">Required</option>

                                        @elseif($records->coupon_status=="1")
                                        <option value="0">Not Required</option>
                                        <option value="1" selected="selected">Required</option>

                                        @else
                                        <option value="2" selected="selected">Please select Coupon required type
                                        </option>
                                        <option value="0">Not Required</option>
                                        <option value="1">Required</option>
                                        @endif

                                        @else
                                        <option value="2" selected="selected">Please select Coupon required type
                                        </option>
                                        <option value="0">Not Required</option>
                                        <option value="1">Required</option>
                                        @endif

                                    </select>

                                </div>


                                <div class="form-group">
                                <label>Select MiniApp</label>
                                <select class="form-control select2" style="width: 100%;" name="miniAppID">

                                    <option value="0" {{ (!$records || $records->miniAppID == '0') ? 'selected' : '' }}>
                                        Please select miniapp
                                    </option>

                                    @if($miniAppList)
                                        @foreach($miniAppList as $item)
                                            <option value="{{ $item->id }}" 
                                                {{ ($records && $item->id == $records->miniAppID) ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                                </div>





                                <!-- For Make Mandotory Image an dFor Multiple Images
                                <input type="file" id="file-upload" name="icon" multiple required />
-->


                                <!-- <div class="form-group">
                                    <label for="exampleInputFile">Upload Image </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="file-upload" name="image" />

                                        </div>
                                    </div>
                                </div>



                                @if($records)
                                <img src="{{ asset('upload/images/'.$records->image) }}" width="70px"
                                    height="70px"></img>
                                @endif -->



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