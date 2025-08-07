@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">


    <center>
        <h1>Loot Offers List</h1>
    </center>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    <form action="AddOrUpdateLootOffers" method="get">
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
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Mini Apps</th>
                    <th scope="col">Coupon Code</th>
                    <th scope="col">Price</th>
                    <th scope="col">Discounted Price</th>

                    <th scope="col">end_date</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>

            @if(isset($records))
            @foreach($records as $item)

            <tr>
                <th style="width:100px" scope="row">{{$item->id}}</th>
                <td>
                    <img src="{{ $item->image }}" width="70px" height="70px"></img>
                </td>
                <td style="width:250px">
                    <center>{{$item->title}}</center>
                </td>

                <td  >

                    @if($item->miniAppID=='0')
                    <option value="0" selected="selected">Please select</option>

                    @else

                    @foreach($miniAppList as $items)
                    @if($items->id == $item->miniAppID)

                    <option value="{{$items->id}}" selected="selected">{{$items->name}}</option>

                    @endif

                    @endforeach

                    @endif


                </td>



                <td style="width:200px">
                    <center>{{$item->coupon_code ?? 'Coupon Not Required'}}</center>
                </td>
                <td>
                    <center>{{$item->price}}</center>
                </td>
                <td>
                    <center>{{$item->dis_price}}</center>
                </td>



                <td style="width:100px">
                    <center>{{$item->end_date}}</center>
                </td>


                <td>

                    <form method="get">

                        <button type="submit" formaction="AddOrUpdateLootOffers" class="btn btn-primary" name="id"
                            value="{{$item->id}}">Update</button>
                        <button type="submit" style="margin-left:15px;background-color:red"
                            formaction="DeleteLootOffers" class="btn btn-primary" name="id"
                            value="{{$item->id}}">Delete</button>
                        <button type="submit" style="margin-left:15px;background-color:red"
                            formaction="ActivateDeactivateLootOffers" class="btn btn-primary" name="id"
                            value="{{$item->id}}">{{$item->status == '1' ? 'Deactive' : 'Active'}}</button>


                    </form>

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