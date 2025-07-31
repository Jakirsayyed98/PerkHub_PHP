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


                        <form action="updateProcess" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="hidden" name="id" value="{{$records->id ?? '0'}}">
                                    <input type="name" class="form-control" value="{{$records->name ?? ''}}" name="name"
                                        placeholder="Enter name">
                                </div>


                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label>Select Category</label>

                                    <select class="form-control select2" style="width: 100%;" name="category_id">
                                        @if($records)
                                        @if($records->miniapp_category_id=="0")
                                        <option value="0" selected="selected">Please select category</option>
                                        @endif

                                        @foreach($category as $item)
                                        @if($records->miniapp_category_id==$item->id)
                                        <option value="{{$item->id}}" selected="selected">{{$item->name}}</option>
                                        @else
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endif
                                        @endforeach

                                        @else
                                        <option value="0" selected="selected">Please select category</option>
                                        @foreach($category as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                              

                                <div class="form-group">
                                    <label>Select url type</label>
                                    <select class="form-control select2" style="width: 100%;" name="url_type">
                                        @if($records)
                                        @if($records->url_type=="2")
                                        <option value="1">Inside</option>
                                        <option value="2" selected="selected">Outside</option>


                                        @elseif($records->url_type=="1")
                                        <option value="1" selected="selected">Inside</option>
                                        <option value="2">Outside</option>
                                        @else
                                        <option value="0" selected="selected">Please select url type</option>
                                        <option value="1">Inside</option>
                                        <option value="2">Outside</option>

                                        @endif
                                        @else
                                        <option value="0" selected="selected">Please select url type</option>
                                        <option value="1">Inside</option>
                                        <option value="2">Outside</option>

                                        @endif
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label>Select macro_publisher</label>
                                    <select class="form-control select2" style="width: 100%;" name="macro_publisher">
                                        @if($records)       
                                               
                                            @if($records->macro_publisher=="0")
                                                <option value="0" selected="selected">Please select Provider</option>
                                                @foreach($affiliate_partner as $affiliate)
                                                <option value="{{$affiliate->id}}">{{$affiliate->Affiliate_name }}</option>
                                                @endforeach
                                            @else

                                                @foreach($affiliate_partner as $affiliate)
                                                    @if($records->macro_publisher == $affiliate->id)
                                                    <option value="{{$affiliate->id}}" selected="selected">{{$affiliate->Affiliate_name}}</option>
                                                    @else
                                                    <option value="{{$affiliate->id}}">{{$affiliate->Affiliate_name }}</option>
                                                    @endif
                                                @endforeach

                                            @endif

                                        @else    

                                            <option value="0" selected="selected">Please select Provider</option>

                                            @foreach($affiliate_partner as $affiliate)
                                            <option value="{{$affiliate->id}}">{{$affiliate->Affiliate_name }}</option>
                                            @endforeach

                                        @endif

                                    </select>
                                </div>


                                

                                <div class="form-group">
                                    <label>Select cb active type</label>
                                    <select class="form-control select2" style="width: 100%;" name="cb_active">

                                        @if($records)



                                        @if($records->cb_active=="0")
                                        <option value="0" selected="selected">Deactive</option>
                                        <option value="1">Active</option>

                                        @elseif($records->cb_active=="1")
                                        <option value="0">Deactive</option>
                                        <option value="1" selected="selected">Active</option>

                                        @else
                                        <option value="2" selected="selected">Please select cb active type</option>
                                        <option value="0">Deactive</option>
                                        <option value="1">Active</option>
                                        @endif

                                        @else
                                        <option value="2" selected="selected">Please select cb active type</option>
                                        <option value="0">Deactive</option>
                                        <option value="1">Active</option>
                                        @endif

                                    </select>

                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPassword1">Cashback Percentage</label>

                                    <input type="text" class="form-control" id=""
                                        value="{{$records->cb_percentage  ?? ''}} "
                                        placeholder="Enter Cashback Percentage" name="cb_percentage">
                                </div>


                                <!-- 
                                <div class="form-group">
                                    <label for="exampleInputPassword1">description</label>
                                    <input type="text" class="form-control" id=""
                                        value="{{$records->description  ?? ''}} " placeholder="Enter description"
                                        name="description">
                                </div> -->

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Description</label>
                                    <textarea id="compose-textarea" class="form-control" style="height: 300px"
                                        name="description">
                                {{$records->description  ?? ''}}
                                </textarea>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPassword1">About Brand</label>
                                    <input type="text" class="form-control" id="" value="{{$records->about  ?? ''}} "
                                        placeholder="Enter About brand" name="about">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">How it's work's</label>
                                    <input type="text" class="form-control" id=""
                                        value="{{$records->howitswork  ?? ''}} " placeholder="Enter How does it work"
                                        name="work">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">url</label>
                                    <input type="text" class="form-control" id="" value="{{$records->url  ?? ''}} "
                                        placeholder="Enter Url" name="url">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">label</label>

                                    <input type="text" class="form-control" id="" value="{{$records->label ?? ''}} "
                                        placeholder="Enter label" name="label">
                                </div>

                                <!-- For Make Mandotory Image an dFor Multiple Images
                                <input type="file" id="file-upload" name="icon" multiple required />
-->

                                <div class="form-group">
                                    <label for="exampleInputFile">Upload Icon </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="file-upload" name="icon" />

                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="form-group">
                                    <label for="exampleInputFile">Upload Icon</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                name="icon">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div> -->
                                @if($records)
                                <img src="{{ asset('upload/images/'.$records->icon) }}" width="70px"
                                    height="70px"></img>
                                @endif


                                <div class="form-group">
                                    <label for="exampleInputFile">Upload logo </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="file-upload" name="logo" />

                                        </div>
                                    </div>
                                </div>


                                @if($records)
                                <img src="{{ asset('upload/images/'.$records->logo) }}" width="90px"
                                    height="70px"></img>
                                @endif

                                <div class="form-group">
                                    <label for="exampleInputFile">Upload banner </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="file-upload" name="banner" />

                                        </div>
                                    </div>
                                </div>


                                @if($records)
                                <img src="{{ asset('upload/images/'.$records->banner) }}" width="150px"
                                    height="70px"></img>
                                @endif


                                <!-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div> -->
                            </div>


                            <!-- /.col -->

                            <div class="form-group">
                                <textarea id="compose-textarea1" class="form-control" style="height: 300px"
                                    name="cashback_terms">
                                {{$records->cashback_terms  ?? ''}}
                                </textarea>
                            </div>

                            <!-- /.col -->


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