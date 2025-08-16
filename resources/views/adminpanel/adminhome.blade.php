@extends('adminpanel.layout.main')
@section('main-container')

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


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admin"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- First Row -->
            <div class="row">
                <!-- Users -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box bg-primary shadow-sm">
                        <div class="inner">
                            <h3>{{ $records->count() ?? 0 }}</h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="Users" class="small-box-footer">
                            View Users <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Categories -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box bg-info shadow-sm">
                        <div class="inner">
                            <h3>{{ $category->count() ?? 0 }}</h3>
                            <p>MiniApps Categories</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-th-list"></i>
                        </div>
                        <a href="MiniAppCategoryList" class="small-box-footer">
                            Manage Categories <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Mini Apps -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box bg-success shadow-sm">
                        <div class="inner">
                            <h3>{{ $MiniAppData->count() ?? 0 }}</h3>
                            <p>Mini Apps</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <a href="MiniAppList" class="small-box-footer">
                            View Mini Apps <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Transactions -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box bg-danger shadow-sm">
                        <div class="inner">
                            <h3>{{ $transactions->count() ?? 0 }}</h3>
                            <p>MiniApp Transactions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <a href="MiniApptransaction" class="small-box-footer">
                            View Transactions <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Second Row -->
            <div class="row">
                <!-- Withdrawal Requests -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box bg-warning shadow-sm">
                        <div class="inner">
                            <h3>{{ $withdrawalRes->count() ?? 0 }}</h3>
                            <p>Withdrawal Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <a href="WithdrawalList?status=pending" class="small-box-footer">
                            Review Requests <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Game Categories -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box bg-secondary shadow-sm">
                        <div class="inner">
                            <h3>{{ $GamesCate->count() ?? 0 }}</h3>
                            <p>Game Categories</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <a href="GamesCategoryList" class="small-box-footer">
                            Manage Games <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Games -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box bg-dark shadow-sm">
                        <div class="inner">
                            <h3>{{ $Games->count() ?? 0 }}</h3>
                            <p>Games</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dice"></i>
                        </div>
                        <a href="GamesList" class="small-box-footer">
                            View Games <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Extra Transactions -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box bg-danger shadow-sm">
                        <div class="inner">
                            <h3>{{ $transactions->count() ?? 0 }}</h3>
                            <p>Total Transactions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Detailed Report <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

@endsection
