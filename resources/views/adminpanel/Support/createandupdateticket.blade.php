@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1>
                        <i class="fas fa-ticket-alt"></i>
                        {{ $ticket ? 'Ticket #' . $ticket->id : 'Create Ticket' }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Ticket Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Left Column: Ticket Form -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{ $ticket ? 'Update Ticket' : 'Create Ticket' }}</h3>
                        </div>

                        <form action="{{ route('admin.ticket.create.process') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="id" value="{{ $ticket->id ?? '' }}">

                                <!-- User -->
                                <div class="form-group">
                                    <label for="user_id">User (Optional)</label>
                                    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" id="user_id">
                                        <option value="">Select User</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $ticket->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name ?? $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <!-- Subject -->
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                           id="subject" name="subject"
                                           value="{{ old('subject', $ticket->subject ?? '') }}"
                                           placeholder="Enter ticket subject">
                                    @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="compose-textarea"
                                              class="form-control @error('description') is-invalid @enderror"
                                              style="height: 200px"
                                              name="description">{{ old('description', $ticket->description ?? '') }}</textarea>
                                    @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <!-- Order -->
                                <div class="form-group">
                                    <label for="order_id">Order (Optional)</label>
                                    <select name="order_id" class="form-control @error('order_id') is-invalid @enderror" id="order_id">
                                        <option value="">Select Order</option>
                                        @foreach (\App\Models\Order::all() as $order)
                                            <option value="{{ $order->id }}" {{ old('order_id', $ticket->order_id ?? '') == $order->id ? 'selected' : '' }}>
                                                Order #{{ $order->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                                        <option value="open" {{ old('status', $ticket->status ?? 'open') == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in_progress" {{ old('status', $ticket->status ?? 'open') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ old('status', $ticket->status ?? 'open') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                    @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <a href="{{ route('admin.ticket.list') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Messaging Thread -->
                @if ($ticket)
                <div class="col-md-6">
                    <div class="card shadow-sm border-info direct-chat direct-chat-primary">
                        <div class="card-header bg-info">
                            <h3 class="card-title"><i class="fas fa-comments"></i> Messaging Thread</h3>
                        </div>

                        <div class="card-body">
                            <div class="direct-chat-messages" style="height: 400px; overflow-y: auto;">
                                <!-- Original Ticket -->
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name">{{ $ticket->user ? ($ticket->user->name ?? $ticket->user->email) : 'Guest' }}</span>
                                        <span class="direct-chat-timestamp">{{ $ticket->created_at->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="direct-chat-text bg-light">
                                        {{ $ticket->description }}
                                    </div>
                                </div>

                                <!-- Replies -->
                                @forelse ($ticket->replies as $reply)
                                    <div class="direct-chat-msg {{ $reply->admin_id ? 'right' : '' }}">
                                        <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name">{{ $reply->admin ? $reply->admin->name : 'User' }}</span>
                                            <span class="direct-chat-timestamp">{{ $reply->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                        <div class="direct-chat-text">
                                            {{ $reply->message }}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted text-center mt-3"><i class="fas fa-info-circle"></i> No replies yet.</p>
                                @endforelse
                            </div>

                            <!-- Reply Form -->
                            <form action="{{ route('tickets.reply', $ticket->id) }}" method="post">
                                @csrf
                                <div class="input-group mt-3">
                                    <textarea name="message" class="form-control" placeholder="Type your reply..." required></textarea>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                                    </div>
                                </div>
                                @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                            </form>
                        </div>

                        <!-- Footer Actions -->
                        <div class="card-footer">
                            <div class="btn-group">
                                <form action="{{ route('tickets.resolve', $ticket->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Resolve</button>
                                </form>
                                <form action="{{ route('tickets.reopen', $ticket->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-redo"></i> Reopen</button>
                                </form>
                                <a href="{{ route('admin.ticket.delete', $ticket->id) }}"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this ticket?')">
                                   <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>
</div>

@endsection
