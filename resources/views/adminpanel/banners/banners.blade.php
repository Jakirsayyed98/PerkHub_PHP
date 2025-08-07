@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">


    <center>
        <h1>Banners List {{$banner_id}}</h1>
    </center>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
    <form method="get">
    <input type="hidden" name="id"  value="0">
                    <input type="hidden" name="banner_id"  value="{{$banner_id}}">
    <button type="submit" formaction="AddAndUpdateBanner" class="btn btn-primary" >+ Add new</button>
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
                <tr >
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">url</th>
                    <th scope="col">image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            @if(isset($records))
            @foreach($records as $item)
            <tr>

                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->url}}</td>
                <td>
                    <center><img src="{{$item->image}}" width="120px" height="70px"></img>
                    </center>
                </td>
                <td>
                    <form method="get">
                    <input type="hidden" name="id"  value="{{$item->id}}">
                    <input type="hidden" name="banner_id"  value="{{$item->banner_id}}">
                    <button type="submit" formaction="AddAndUpdateBanner" class="btn btn-primary" >Update</button>
                    <button style="margin-left:15px;background-color:red" formaction="deleteBanner" class="btn btn-primary" type="Delete" >Delete</button>
                    <button style="margin-left:15px;background-color:red" formaction="ActiveDeactivebanner" class="btn btn-primary" type="submit" >{{$item->status == '1' ? 'Deactive' : 'Active'}}</button>
                    </form>
                </td>
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