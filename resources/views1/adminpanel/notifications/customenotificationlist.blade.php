@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">


    <center>
        <h1>Admin Notification List</h1>
    </center>

 

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <form action="CreateNotificationAndUpdate" method="get">
                            <button type="submit" class="btn btn-primary" name="id" value="0" style="margin-right:15px;">+ Add new</button>
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
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            @if(isset($notificationList))
            @foreach($notificationList as $item)

            <tr>
                <th  scope="row">{{$item->id}}</th>
                <td >{{$item->title}}</td>
                <td >{{$item->description}}</td>
                <form method="get">
                    <th>
                        <button style="margin-left:15px;background-color:red" formaction="deleteNotificationProcess"
                            class="btn btn-primary" name="id" type="Delete" value="{{$item->id}}">Delete</button>

                        <button type="submit" formaction="CreateNotificationAndUpdate" class="btn btn-primary" name="id"
                            value="{{$item->id}}">Update</button>
                       
                        <button type="submit" formaction="sendAdminNotifications" class="btn btn-primary" name="id"
                            value="{{$item->id}}">Send Notification</button>

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