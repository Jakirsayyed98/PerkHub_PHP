@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mini App Transactions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Transactions</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <!-- Import Excel -->
                                <form action="{{ url('UploadTxn') }}" method="POST" enctype="multipart/form-data" class="form-inline d-inline-block">
                                    @csrf
                                    <input type="file" name="excel_file" class="form-control mr-2" required>
                                    <button type="submit" class="btn btn-success">Import</button>
                                </form>

                                <!-- Export Excel -->
                                <form method="get" action="{{ url('BulkMiniAppTxn') }}" class="d-inline-block ml-2">
                                    <button type="submit" class="btn btn-primary">Export Excel</button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Store</th>
                                        <th>Order ID</th>
                                        <th>Amount</th>
                                        <th>Affiliate Commission</th>
                                        <th>User Commission</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->store_name }}</td>
                                            <td>{{ $item->order_id }}</td>
                                            <td>₹{{ number_format($item->order_amount, 2) }}</td>
                                            <td>₹{{ number_format($item->affiliate_commission, 2) }}</td>
                                            <td>₹{{ number_format($item->user_commission, 2) }}</td>
                                            <td>
                                                @if($item->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($item->status == 'approved')
                                                    <span class="badge badge-success">Verified</span>
                                                @else
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button 
                                                    class="btn btn-sm btn-primary view-transaction"
                                                    data-toggle="modal" 
                                                    data-target="#transactionModal"
                                                    data-id="{{ $item->id }}"
                                                    data-user="{{ $item->user_id }}"
                                                    data-storeid="{{ $item->store_id }}"
                                                    data-store="{{ $item->store_name }}"
                                                    data-affprovider="{{ $item->affiliate_provider_id }}"
                                                    data-ref="{{ $item->reference_id }}"
                                                    data-order="{{ $item->order_id }}"
                                                    data-date="{{ $item->transaction_date }}"
                                                    data-amount="₹{{ number_format($item->order_amount, 2) }}"
                                                    data-affcomm="₹{{ number_format($item->affiliate_commission, 2) }}"
                                                    data-usercomm="₹{{ number_format($item->user_commission, 2) }}"
                                                    data-percent="{{ $item->user_commission_percent }}"
                                                    data-status="{{ ucfirst($item->status) }}"
                                                    data-subid="{{ $item->subid }}"
                                                    data-subid1="{{ $item->subid1 }}"
                                                    data-subid2="{{ $item->subid2 }}"
                                                    data-subid3="{{ $item->subid3 }}"
                                                    data-created="{{ $item->created_at }}"
                                                    data-updated="{{ $item->updated_at }}"
                                                >
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No transactions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="transactionModalLabel">Transaction Details</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <tbody>
              <tr><th>ID</th><td id="txn_id"> {{ $item->id }}</td></tr>
              <tr><th>User ID</th><td id="txn_user">{{ $item->user_id }}</td></tr>
              <tr><th>Store ID</th><td id="txn_storeid">{{ $item->store_id }}</td></tr>
              <tr><th>Store Name</th><td id="txn_store">{{ $item->store_name }}</td></tr>
              <tr><th>Affiliate Provider</th><td id="txn_affprovider">{{ $item->affiliateProvider->name }}</td></tr>
              <tr><th>Reference ID</th><td id="txn_ref">{{ $item->reference_id }}</td></tr>
              <tr><th>Order ID</th><td id="txn_order">{{ $item->order_id }}</td></tr>
              <tr><th>Transaction Date</th><td id="txn_date">{{ $item->transaction_date }}</td></tr>
              <tr><th>Sale Amount</th><td id="txn_amount">₹{{ number_format($item->order_amount, 2) }}</td></tr>
              <tr><th>Affiliate Commission</th><td id="txn_aff_comm">₹{{ number_format($item->affiliate_commission, 2) }}</td></tr>
              <tr><th>User Commission</th><td id="txn_user_comm">₹{{ number_format($item->user_commission, 2) }}</td></tr>
              <tr><th>User Commission %</th><td id="txn_percent">{{ $item->user_commission_percent }}%</td></tr>
              <tr><th>Status</th><td id="txn_status">{{ $item->status }}</td></tr>
              <tr><th>SubID</th><td id="txn_subid">{{ $item->subid }}</td></tr>
              <tr><th>SubID1</th><td id="txn_subid1">{{ $item->subid1 }}</td></tr>
              <tr><th>SubID2</th><td id="txn_subid2">{{ $item->subid2 }}</td></tr>
              <tr><th>SubID3</th><td id="txn_subid3">{{ $item->subid3 }}</td></tr>
              <tr><th>Created At</th><td id="txn_created">{{ $item->created_at }}</td></tr>
              <tr><th>Updated At</th><td id="txn_updated">{{ $item->updated_at }}</td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
  $('.view-transaction').on('click', function () {
    $('#txn_id').text($(this).data('id'));
    $('#txn_user').text($(this).data('user'));
    $('#txn_storeid').text($(this).data('storeid'));
    $('#txn_store').text($(this).data('store'));
    $('#txn_affprovider').text($(this).data('affprovider'));
    $('#txn_ref').text($(this).data('ref'));
    $('#txn_order').text($(this).data('order'));
    $('#txn_date').text($(this).data('date'));
    $('#txn_amount').text($(this).data('amount'));
    $('#txn_aff_comm').text($(this).data('affcomm'));
    $('#txn_user_comm').text($(this).data('usercomm'));
    $('#txn_percent').text($(this).data('percent') + '%');
    $('#txn_status').text($(this).data('status'));
    $('#txn_subid').text($(this).data('subid'));
    $('#txn_subid1').text($(this).data('subid1'));
    $('#txn_subid2').text($(this).data('subid2'));
    $('#txn_subid3').text($(this).data('subid3'));
    $('#txn_created').text($(this).data('created'));
    $('#txn_updated').text($(this).data('updated'));
  });
});
</script>
@endpush
