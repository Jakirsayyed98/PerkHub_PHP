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
                    <form action="ExportExcel" method="get">

<button type="submit" class="btn btn-primary" name="id" value="0" style="margin-right:15px;">Export Excel</button>
</form>
<form action="UpdateMiniApp" method="get">
<button type="submit" class="btn btn-primary" name="id" value="0" style="margin-right:15px;">+ Add
    new</button>
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
                    <th scope="col">Campaign Provider</th>
                    <th scope="col">Icon</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Banner</th>
                    <th scope="col">popular</th>

                    <th scope="col">trending</th>
                    <th scope="col">top_cashback</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            @if(isset($records))
            @foreach($records as $item)

            <tr>
                <th  scope="row">{{$item->id}}</th>

                <td style="width:200px">{{$item->name}}</td>

                <td style="width:100px"><center>@if($item->macro_publisher=="1") CueLinks @else Inr Deals @endif</center></td>

                <td>
                <img src="{{ asset('upload/images/'.$item->icon) }}" width="90px"
                                    height="70px"></img>
                </td>

                <td>
                <img src="{{ asset('upload/images/'.$item->logo) }}" width="90px"
                                    height="70px"></img>
                </td>

                <td>
                <img src="{{ asset('upload/images/'.$item->banner) }}" width="150px"
                                    height="70px"></img>
                </td>
               

                <form method="get">

                    <td><button style="margin-left:15px;background-color:red" formaction="popularActiveDeactive"
                            class="btn btn-primary" type="submit" name="id"
                            value="{{$item->id}}">{{$item->popular == '1' ? 'Deactive' : 'Active'}}</button></td>
                    <td><button style="margin-left:15px;background-color:red" formaction="trendingActiveDeactive"
                            class="btn btn-primary" type="submit" name="id"
                            value="{{$item->id}}">{{$item->trending == '1' ? 'Deactive' : 'Active'}}</button></td>
                    <td><button style="margin-left:15px;background-color:red" formaction="top_cashbackActiveDeactive"
                            class="btn btn-primary" type="submit" name="id"
                            value="{{$item->id}}">{{$item->top_cashback == '1' ? 'Deactive' : 'Active'}}</button></td>



                    <th>
                        <button type="submit" formaction="UpdateMiniApp" class="btn btn-primary" name="id"
                            value="{{$item->id}}">Update</button>
                        <button style="margin-left:15px;background-color:red" formaction="deleteProcess"
                            class="btn btn-primary" name="id" type="Delete" value="{{$item->id}}">Delete</button>
                        <button style="margin-left:15px;background-color:red" formaction="miniAppActiveDeactive"
                            class="btn btn-primary" type="submit" name="id"
                            value="{{$item->id}}">{{$item->status == '1' ? 'Deactive' : 'Active'}}</button>

                    </th>

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