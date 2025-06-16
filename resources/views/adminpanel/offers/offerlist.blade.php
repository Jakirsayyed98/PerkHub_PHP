@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">


    <center>
        <h1>Offers List</h1>
    </center>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <form action="AddOrUpdateOffer" method="get">
                            <button type="submit" class="btn btn-primary" name="id" value="0"
                                style="margin-right:15px;">+ Add
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
                                        <th scope="col">title</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Coupon code</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">End date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                                @if(isset($records))
                                @foreach($records as $item)

                                <tr>
                                    <th style="width:100px" scope="row">{{$item->id}}</th>

                                    <td style="width:250px">
                                        <center>{{$item->title}}</center>
                                    </td>

                                    <td>
                                        <img src="{{ asset('upload/images/'.$item->image) }}" width="90px"
                                            height="70px"></img>
                                    </td>

                                    <td style="width:250px">
                                        <center>{{$item->coupon_code}}</center>
                                    </td>

                                    <td style="width:250px">
                                        <center>{{$item->type == '1' ? 'Coupon' : 'Offer'}}</center>
                                    </td>

                                    <td style="width:250px">
                                        <center>{{$item->end_date}}</center>
                                    </td>

                                    <form method="get">



                                        <th>
                                            <button type="submit" formaction="AddOrUpdateOffer" class="btn btn-primary"
                                                name="id" value="{{$item->id}}">Update</button>

                                            <button style="margin-left:15px;background-color:red"
                                                formaction="deleteOfferProcess" class="btn btn-primary" name="id"
                                                type="Delete" value="{{$item->id}}">Delete</button>

                                            <button style="margin-left:15px;background-color:red"
                                                formaction="OfferActiveDeactive" class="btn btn-primary" type="submit"
                                                name="id"
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