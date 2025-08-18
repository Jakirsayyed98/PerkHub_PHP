@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1>Ticket List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Section -->
    <section class="content">
        <div class="container-fluid">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-ticket-alt"></i> Tickets</h3>
                </div>

                <div class="card-body">
                    
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <!-- Tickets Table -->
                    <table id="ticketTable" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>User</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center" style="width:150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ticketList as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>{{ $ticket->user ? ($ticket->user->name ?? $ticket->user->email) : 'N/A' }}</td>
                                    <td>{{ $ticket->order ? 'Order #' . $ticket->order->id : 'N/A' }}</td>
                                    <td>
                                        @if ($ticket->status == 'open')
                                            <span class="badge badge-success">Open</span>
                                        @elseif ($ticket->status == 'in_progress')
                                            <span class="badge badge-warning">In Progress</span>
                                        @elseif ($ticket->status == 'closed')
                                            <span class="badge badge-secondary">Closed</span>
                                        @else
                                            <span class="badge badge-light">{{ ucfirst($ticket->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('CreateTicketAndUpdate/' . $ticket->id) }}" 
                                           class="btn btn-sm btn-info" title="Edit">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.ticket.delete', ['id' => $ticket->id]) }}" 
                                              method="POST" 
                                              style="display:inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <i class="fas fa-info-circle"></i> No tickets found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Optional Pagination (if using paginate) -->
                @if(method_exists($ticketList, 'links'))
                    <div class="card-footer clearfix">
                        {{ $ticketList->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

        </div>
    </section>
</div>

<!-- DataTables Script -->
@push('scripts')
<script>
    $(function () {
        $("#ticketTable").DataTable({
            "responsive": true,
            "autoWidth": false,
            "ordering": true,
            "pageLength": 10
        });
    });
</script>
@endpush

@endsection
