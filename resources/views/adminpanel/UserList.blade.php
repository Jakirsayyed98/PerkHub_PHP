@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">


    <center>
        <h1>User List</h1>
    </center>

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
                                        <th scope="col">email</th>
                                        <th scope="col">number</th>
                                        <th scope="col">Pending</th>
                                        <th scope="col">Verified</th>
                                        <th scope="col">Rejected</th>


                                        <th scope="col">gender</th>
                                        <th scope="col">status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                                @if(isset($records))
                                @foreach($records as $item)
                                <form method="get">
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <tr>
                                        <th style="width:50px" scope="row">{{$item->id}}</th>
                                        <td style="width:150px">{{$item->name}}</td>
                                        <td style="width:200px">{{$item->email}}</td>
                                        <td style="width:250px">{{$item->number}}</td>
                                        <td style="width:100px">{{$item->pending}}</td>
                                        <td style="width:100px">{{$item->verified}}</td>
                                        <td style="width:100px">{{$item->rejected}}</td>


                                        @if($item->gender=="0")
                                        <td style="width:100px">Male</td>
                                        @elseif($item->gender=="1")
                                        <td style="width:100px">Female</td>
                                        @else
                                        <td style="width:100px">Other</td>
                                        @endif

                                        @if($item->status=="0")
                                        <td style="width:100px">Unverified</td>
                                        @elseif($item->status=="1")
                                        <td style="width:100px">Verified</td>
                                        @else
                                        <td style="width:100px">Block</td>
                                        @endif



                                        <td scope="col">
                                            @if($item->status=="0")
                                            <button type="submit" formaction="UserBlockUnBlock" class="btn btn-primary"
                                                name="status" value="{{$item->id}}">Block</button>
                                            @elseif($item->status=="1")
                                            <button type="submit" formaction="UserBlockUnBlock" class="btn btn-primary"
                                                name="status" value="{{$item->id}}">Block</button>
                                            @else
                                            <button type="submit" formaction="UserBlockUnBlock" class="btn btn-primary"
                                                name="status" value="{{$item->id}}">UnBlock</button>
                                            @endif

                                            <button style="margin-left:15px;background-color:red" type="submit"
                                                formaction="UserDelete" class="btn btn-primary" name="Delete"
                                                value="{{$item->id}}">Delete</button>
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