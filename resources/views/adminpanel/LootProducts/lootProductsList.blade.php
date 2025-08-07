@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">


    <center>
        <h1>Loot Products List</h1>
    </center>

 

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DataTables</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

<form action="AddOrUpdateLootProduct" method="get">
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
                    <th scope="col">Image</th>
                    <th scope="col">Offer Type</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            @if(isset($lootproducts))
            @foreach($lootproducts as $item)

            <tr>
                <th  scope="row">{{$item->id}}</th>

                <td style="width:200px">{{$item->product_name}}</td>

                <td>
                <img src="{{ $item->image_url }}" width="90px"
                                    height="70px"></img>
                </td>

                <td style="width:100px"><center>@if($item->offer_type=="1") Coupon @else Offers @endif</center></td>

                <td style="width:200px">{{$item->offer_expiry}}</td>

               
                <form method="get">
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