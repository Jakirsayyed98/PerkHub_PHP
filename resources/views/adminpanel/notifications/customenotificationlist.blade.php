@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1>Admin Notifications</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <form action="{{ url('CreateNotificationAndUpdate') }}" method="get" style="display:inline;">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Add New
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @if(isset($notificationList) && count($notificationList) > 0)
                                    @foreach($notificationList as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->message }}</td>
                                            <td class="text-center">
                                                <form method="get" style="display:inline;">
                                                    <!-- Update -->
                                                    <button type="submit" 
                                                            formaction="{{ url('CreateNotificationAndUpdate') }}" 
                                                            class="btn btn-primary btn-sm" 
                                                            name="id" 
                                                            value="{{ $item->id }}">
                                                        <i class="fas fa-edit"></i> Update
                                                    </button>

                                                    <!-- Delete -->
                                                    <button type="submit" 
                                                            formaction="{{ url('deleteNotificationProcess') }}" 
                                                            class="btn btn-danger btn-sm" 
                                                            name="id" 
                                                            value="{{ $item->id }}"
                                                            onclick="return confirm('Are you sure you want to delete this notification?');">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>

                                                    <!-- Send Notification -->
                                                    <button type="submit" 
                                                            formaction="{{ url('sendAdminNotifications') }}" 
                                                            class="btn btn-warning btn-sm" 
                                                            name="id" 
                                                            value="{{ $item->id }}">
                                                        <i class="fas fa-bell"></i> Send
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No notifications found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@endsection
