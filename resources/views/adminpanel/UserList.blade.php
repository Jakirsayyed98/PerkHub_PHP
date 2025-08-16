@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-users mr-2"></i> User List
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admin"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->


    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-user-friends mr-2"></i> Registered Users</h3>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-hover table-bordered table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($records) && $records->count() > 0)
                                @foreach($records as $item)
                                    <form method="get">
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->mobile }}</td>
                                            <td>
                                                @if($item->gender == "male")
                                                    <span class="badge badge-primary">Male</span>
                                                @elseif($item->gender == "female")
                                                    <span class="badge badge-pink">Female</span>
                                                @else
                                                    <span class="badge badge-secondary">Other</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->status == "0")
                                                    <span class="badge badge-warning">Unverified</span>
                                                @elseif($item->status == "1")
                                                    <span class="badge badge-success">Verified</span>
                                                @else
                                                    <span class="badge badge-danger">Blocked</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($item->status == "0" || $item->status == "1")
                                                    <button type="submit" formaction="UserBlockUnBlock" class="btn btn-sm btn-warning" name="status" value="{{ $item->id }}">
                                                        <i class="fas fa-ban"></i> Block
                                                    </button>
                                                @else
                                                    <button type="submit" formaction="UserBlockUnBlock" class="btn btn-sm btn-success" name="status" value="{{ $item->id }}">
                                                        <i class="fas fa-unlock"></i> Unblock
                                                    </button>
                                                @endif

                                                <button type="submit" formaction="UserDelete" class="btn btn-sm btn-danger ml-2" name="Delete" value="{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No users found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->

</div>
@endsection
