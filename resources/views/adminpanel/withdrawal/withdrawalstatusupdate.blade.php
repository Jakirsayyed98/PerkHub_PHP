@extends('adminpanel.layout.main')
@section('main-container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>General Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">General Form</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">User Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <div class="card-body">

                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">User Name</label>
                                            <input type="hidden" name="id" value="{{$usermodel->user_id ?? '0'}}">
                                            <input type="name" disabled class="form-control"
                                                value="{{$usermodel->name ?? ''}}" name="name"
                                                placeholder="Enter title">
                                        </div>

                                       


                                    </div>
                                    <!-- /.card-body -->
                                    <!-- Right column -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="exampleInputEmail1">Mobile Number</label>
                                            <input type="name" disabled class="form-control"
                                                value="{{$usermodel->number ?? ''}}" name="number"
                                                placeholder="Enter number">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                               
                                
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Verified</label>
                                            <input type="hidden" name="id" value="{{$records->id ?? '0'}}">
                                            <input type="name" disabled class="form-control"
                                                value="₹{{$usermodel->verified ?? ''}}" name="name"
                                                placeholder="Enter Amount">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <!-- Right column -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="exampleInputEmail1">Pending</label>
                                            <input type="name" disabled class="form-control"
                                                value="₹{{$usermodel->pending ?? ''}}" name="number"
                                                placeholder="Enter Amount">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="exampleInputEmail1">Rejected</label>
                                            <input type="name" disabled class="form-control"
                                                value="₹{{$usermodel->rejected ?? ''}}" name="number"
                                                placeholder="Enter Amount">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <!-- Right column -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="exampleInputEmail1">Withdrawal</label>
                                            <input type="name" disabled class="form-control"
                                                value="₹{{$usermodel->withdrawal ?? ''}}" name="number"
                                                placeholder="Enter Amount">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                               

                            </div>
                    </div>
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Withdrawal Request Info</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="withdrawalstatusupdateProcess" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="card-body">

                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">VPA ID</label>
                                        
                                            <input type="name" disabled class="form-control"
                                                value="{{$records->VPA_Id ?? ''}}" name="VPA"
                                                placeholder="Enter UPI">
                                        </div>

                                       


                                    </div>
                                    <!-- /.card-body -->
                                    <!-- Right column -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="exampleInputEmail1">Requested withdrawal Amount</label>
                                            <input type="name"  class="form-control"
                                                value="₹{{$records->requested_withdrawal_amt ?? ''}}" name="withdrawala"
                                                placeholder="Enter requested_withdrawal_amt" disabled>
                                        </div>
                                    </div>
                                    
                                    <!-- /.card-body -->
                                </div>
                               
                                
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="exampleInputEmail1">Txn Id</label>
                                            <input type="name"   class="form-control"
                                                value="{{$records->txn_id ?? ''}}" name="txn_id"
                                                placeholder="Enter txn_id">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <!-- Right column -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="exampleInputEmail1">message</label>
                                            <input type="name" class="form-control"
                                                value="{{$records->message ?? ''}}" name="message"
                                                placeholder="Enter message">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                                <div class="row">
                                    <!-- left column -->
                                    

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Txn Time</label>
                                            <input type="hidden" name="user_id" value="{{$records->user_id ?? '0'}}">
                                            <input type="hidden" name="withdrawalamount" value="{{$records->requested_withdrawal_amt ?? ''}}">
                                            <input type="hidden" name="id" value="{{$records->id ?? '0'}}">
                                            <input type="name"  class="form-control"
                                                value="{{$records->txn_time ?? ''}}" name="txn_time"
                                                placeholder="Enter txn_time">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <!-- Right column -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Select Status</label>
                                    <select class="form-control select2" style="width: 100%;" name="withdrawal_status">

                                        @if($records)
                                        @if($records->status=="0")
                                        <option value="0" selected="selected">Pending</option>
                                        <option value="1">Completed</option>
                                        <option value="2">Rejected</option>

                                        @elseif($records->status=="1")
                                        <option value="0">Pending</option>
                                        <option value="1" selected="selected">Completed</option>
                                        <option value="2">Rejected</option>

                                        @else
                                        <option value="2" selected="selected">Rejected</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Completed</option>
                                        @endif

                                        @else
                                        <option value="3" selected="selected">Please select status type</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Completed</option>
                                        <option value="2">Rejected</option>
                                        @endif

                                    </select>

                                </div>

                                    <!-- /.card-body -->
                                </div>
                               

                            </div>
                            <ol class="breadcrumb float-sm-right">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </ol>

                        </form>
                    </div>
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->


            
            <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
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

                                    @foreach($transaction as $item)

                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->campaign_name}}</td>
                                        <td>{{$item->transaction_id}}</td>
                                        <td>₹{{$item->sale_amount}}</td>
                                        <td>₹{{$item->affiliate_commission}}</td>
                                        <td>₹{{$item->user_commission}}</td>

                                        @if($item->status == '0')
                                        <td>Pending</td>
                                        @elseif($item->status == '1')
                                        <td>Verified</td>
                                        @else
                                        <td>Rejected</td>
                                        @endif
                                       </tr>

                                    @endforeach

                                </tbody>

                            </table>
                        </div>
            
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection