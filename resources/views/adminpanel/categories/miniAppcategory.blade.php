@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <center>
        <h1>MiniApp Categorys List</h1>
    </center>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <form action="AddOrUpdateCategories" method="get">
                            <input type="hidden" name="" value="0">
                            <button type="submit" class="btn btn-primary" style="margin-right:15px;">+ Add new</button>
                        </form>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


                    <div class="card">
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead bac>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">name</th>
                                        <th scope="col">image</th>
                                        <!-- <th scope="col">status</th> -->
                                        <th scope="col">description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                                @if(isset($records))
                                @foreach($records as $item)

                                <tr>
                                    <th scope="row">{{$item->id}}</th>
                                    <form method="get">
                                        <input type="hidden" name="category_id" value="{{$item->id}}">
                                        <td style="width: 20%;">
                                            <center>{{$item->name}}</center>
                                        </td>
                                        <td>
                                            <center><img src="{{ asset('upload/images/'.$item->image) }}" width="70px"
                                                    height="70px"></img></center>
                                        </td>
                                        <!-- <td ><center>{{$item->status == "1" ? 'Active' : 'Deactive'}}</center></td> -->
                                        <td style="width: 20%;">
                                            <center>{{$item->description}}</center>
                                        </td>
                                        <td scope="col">

                                            <button type="submit" formaction="AddOrUpdateCategories"
                                                class="btn btn-primary" name="Update"
                                                value="{{$item->id}}">Update</button>
                                            <button style="margin-left:15px;background-color:red"
                                                formaction="DeleteCategorie" class="btn btn-primary" type="Delete"
                                                value="{{$item->id}}">Delete</button>
                                            <button style="margin-left:15px;background-color:red"
                                                formaction="ActiveDeactive" class="btn btn-primary" type="submit"
                                                value="{{$item->id}}">{{$item->status == '1' ? 'Deactive' : 'Active'}}</button>
                                            <button style="margin-left:15px;background-color:red"
                                                formaction="ActiveDeactivehomePageVis" class="btn btn-primary" type="submit"
                                                value="{{$item->id}}">{{$item->homepage_visible == '1' ? 'Deactive' : 'Active'}}</button>



                                            <script>

                                            </script>
                                        </td>
                                    </form>
                                </tr>

                                @endforeach

                                @endif



                            </table>

                        </div>
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>


    @endsection