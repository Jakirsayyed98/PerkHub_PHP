@extends('adminpanel.layout.main')
@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $ticket ? 'Ticket #' . $ticket->id : 'Create Ticket' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Ticket Form</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column: Ticket Form -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $ticket ? 'Update Ticket' : 'Create Ticket' }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.ticket.create.process') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <!-- Hidden ID field -->
                                <input type="hidden" name="id" value="{{ $ticket->id ?? '' }}">

                                <!-- User ID -->
                                <div class="form-group">
                                    <label for="user_id">User (Optional)</label>
                                    <select name="user_id" class="form-control" id="user_id">
                                        <option value="">Select User</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $ticket->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name ?? $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Subject -->
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject', $ticket->subject ?? '') }}" placeholder="Enter subject">
                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="compose-textarea" class="form-control" style="height: 200px" name="description">{{ old('description', $ticket->description ?? '') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Order ID -->
                                <div class="form-group">
                                    <label for="order_id">Order (Optional)</label>
                                    <select name="order_id" class="form-control" id="order_id">
                                        <option value="">Select Order</option>
                                        @foreach (\App\Models\Order::all() as $order)
                                            <option value="{{ $order->id }}" {{ old('order_id', $ticket->order_id ?? '') == $order->id ? 'selected' : '' }}>
                                                Order #{{ $order->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="open" {{ old('status', $ticket->status ?? 'open') == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in_progress" {{ old('status', $ticket->status ?? 'open') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ old('status', $ticket->status ?? 'open') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.ticket.list') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->

                <!-- right column: Messaging Thread -->
                @if ($ticket)
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Messaging Thread</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Original Ticket Message -->
                                <div class="direct-chat-messages" style="height: 400px; overflow-y: auto;">
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name">{{ $ticket->user ? ($ticket->user->name ?? $ticket->user->email) : 'Guest' }}</span>
                                            <span class="direct-chat-timestamp">{{ $ticket->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                        <div class="direct-chat-text">
                                            {{ $ticket->description }}
                                        </div>
                                    </div>
                                    <!-- Replies -->
                                    @foreach ($ticket->replies as $reply)
                                        <div class="direct-chat-msg {{ $reply->admin_id ? 'right' : '' }}">
                                            <div class="direct-chat-infos clearfix">
                                                <span class="direct-chat-name">{{ $reply->admin ? $reply->admin->name : 'User' }}</span>
                                                <span class="direct-chat-timestamp">{{ $reply->created_at->format('M d, Y H:i') }}</span>
                                            </div>
                                            <div class="direct-chat-text">
                                                {{ $reply->message }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Reply Form -->
                                <form action="{{ route('tickets.reply', $ticket->id) }}" method="post">
                                    @csrf
                                    <div class="input-group mt-3">
                                        <textarea name="message" class="form-control" placeholder="Type your reply..." required></textarea>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                    </div>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="btn-group">
                                    <form action="{{ route('tickets.resolve', $ticket->id) }}" method="post" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Resolve</button>
                                    </form>
                                    <form action="{{ route('tickets.reopen', $ticket->id) }}" method="post" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Reopen</button>
                                    </form>
                                    <a href="{{ route('admin.ticket.delete', $ticket->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this ticket?')">Delete</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                @endif
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

@endsection