@extends('adminpanel.layout.main')

@section('main-container')

<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Withdrawal Request Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Withdrawal Request</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- User Info -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">User Information</h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="hidden" name="id" value="{{ $usermodel->user_id ?? '0' }}">
                                        <input type="text" disabled class="form-control"
                                               value="{{ $usermodel->name ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" disabled class="form-control"
                                               value="{{ $usermodel->mobile ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Verified</label>
                                        <input type="text" disabled class="form-control"
                                               value="₹{{ $approvedCashback ?? '0' }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pending</label>
                                        <input type="text" disabled class="form-control"
                                               value="₹{{ $pendingCashback ?? '0' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Rejected</label>
                                        <input type="text" disabled class="form-control"
                                               value="₹{{ $rejectedCashback ?? '0' }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total Withdrawal</label>
                                        <input type="text" disabled class="form-control"
                                               value="₹{{ $withdrawalAmount ?? '0' }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Withdrawal Info -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-success">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title">Withdrawal Request Info</h3>
                        </div>

                        <form action="{{ url('withdrawalstatusupdateProcess') }}" method="post">
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Method</label>
                                            <input type="text" disabled class="form-control"
                                                   value="{{ ucfirst($records->method) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Account Details</label>
                                            <input type="text" disabled class="form-control"
                                                   value="{{ $records->account_details ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                @if($records->method == 'bank')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>IFSC Code</label>
                                            <input type="text" disabled class="form-control" name="ifsc_code"
                                                   value="{{ $records->ifsc_code ?? '—' }}">
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Requested Amount</label>
                                            <input type="hidden" name="requested_amount" value="{{ $records->amount ?? '' }}">
                                            <input type="text" disabled class="form-control" name="requested_amount"
                                                   value="₹{{ $records->amount ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Requested At</label>
                                            <input type="text" disabled class="form-control"
                                                   value="{{ $records->requested_at ? \Carbon\Carbon::parse($records->requested_at)->format('d M, Y h:i A') : '—' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Txn ID</label>
                                            <!-- <input type="hidden" name="txn_id" value="{{ $records->txn_id ?? '' }}"> -->

                                            <input type="text" class="form-control"
                                                   name="txn_id"
                                                   value="{{ $records->txn_id ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Processed At</label>
                                            <input type="text" class="form-control"
                                                   name="processed_at"
                                                   value="{{ $records->processed_at ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Admin Note</label>
                                            <textarea class="form-control" name="admin_note" rows="2">{{ $records->admin_note ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="id" value="{{ $records->id ?? '0' }}">
                                        <input type="hidden" name="user_id" value="{{ $records->user_id ?? '0' }}">
                                       <div class="form-group">
    <label>Status</label>
    <select class="form-control select2" name="withdrawal_status" style="width: 100%;">
        <option value="pending"  {{ $records->status == "pending" ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ $records->status == "approved" ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ $records->status == "rejected" ? 'selected' : '' }}>Rejected</option>
    </select>
</div>

                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h3 class="card-title">User Transactions</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover table-striped text-center align-middle">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Transaction Id</th>
                                <th>Sale Amount</th>
                                <th>Commission</th>
                                <th>User Commission</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaction as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->store_name }}</td>
                                    <td>{{ $item->order_id }}</td>
                                    <td>₹{{ $item->order_amount }}</td>
                                    <td>₹{{ $item->affiliate_commission }}</td>
                                    <td>₹{{ $item->user_commission }}</td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($item->status == 'approved')
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No transactions found.</td>
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
