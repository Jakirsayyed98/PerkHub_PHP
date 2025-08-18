@extends('adminpanel.layout.main')
@section('main-container')

{{-- SweetAlert Notifications --}}
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Withdrawal Requests</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <form action="{{ url('ExportWithdrawalsExcel') }}" method="get" class="d-inline">
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">All Withdrawal Requests</h3>
                </div>

                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped text-center align-middle">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>Processed At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($records as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->user_id }}</td>
                                    <td>₹{{ number_format($item->amount, 2) }}</td>
                                    <td>
                                        @if($item->method == 'upi')
                                            <span class="badge bg-info">UPI</span>
                                        @else
                                            <span class="badge bg-secondary">Bank</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($item->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->requested_at ? \Carbon\Carbon::parse($item->requested_at)->format('d M, Y h:i A') : '—' }}</td>
                                    <td>{{ $item->processed_at ? \Carbon\Carbon::parse($item->processed_at)->format('d M, Y h:i A') : '—' }}</td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <form method="GET" action="{{ url('withdrawalstatusupdate') }}" class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-primary" name="id" value="{{ $item->id }}">
                                                    <i class="fas fa-edit"></i> Update
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center text-muted">No withdrawal requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>

@endsection
