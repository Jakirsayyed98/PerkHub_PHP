@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">


    <center>
        <h1>Games Category</h1>
    </center>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <form method="get">

                            <button type="submit" formaction="AddOrUpdateGameCategories" class="btn btn-primary">+ Add
                                new</button>
                            <button type="submit" formaction="RefreshCategory" class="btn btn-primary">Refresh
                                Category</button>
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
                                        <th scope="col">Icon</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                                @if(isset($records))
                                @foreach($records as $item)

                                <form method="get">
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->name}}</td>

                                        <td>
                                            <center><img src="{{ asset('upload/images/'.$item->image) }}" width="70px"
                                                    height="70px"></img></center>
                                        </td>
                                        <td><button type="submit" formaction="AddOrUpdateGameCategories"
                                                class="btn btn-primary" name="Update"
                                                value="{{$item->id}}">Update</button>
                                            <button style="margin-left:15px;background-color:red"
                                                formaction="deleteGameCategory" class="btn btn-primary" type="Delete"
                                                value="{{$item->id}}">Delete</button>
                                            <button style="margin-left:15px;background-color:red"
                                                formaction="ActiveDeactiveGameCategory" class="btn btn-primary"
                                                type="submit"
                                                value="{{$item->id}}">{{$item->status == '1' ? 'Deactive' : 'Active'}}</button>
                                        </td>
                                    </tr>
                                </form>
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