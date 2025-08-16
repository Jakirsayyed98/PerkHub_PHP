@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">
    <center>
        <h1>Affiliate Providers List</h1>
    </center>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <form method="get" action="{{ url('AffiliateAddOrUpdate') }}">
                            @csrf
                            <input type="hidden" name="id" value="0">
                            <button type="submit" class="btn btn-primary">+ Add new</button>
                        </form>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($records) && count($records) > 0)
                                        @foreach($records as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <form method="get">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id }}">

                                                        {{-- Update --}}
                                                        <button type="submit" formaction="{{ url('AffiliateAddOrUpdate') }}" class="btn btn-primary">
                                                            Update
                                                        </button>

                                                        {{-- Delete --}}
                                                        <button type="submit" formaction="{{ url('deleteAffiliate') }}" class="btn btn-danger" style="margin-left:15px;">
                                                            Delete
                                                        </button>

                                                        {{-- Activate / Deactivate --}}
                                                        <button type="submit" formaction="{{ url('ActiveDeactiveAffiliate') }}" class="btn btn-warning" style="margin-left:15px;">
                                                            {{ $item->status == '1' ? 'Deactivate' : 'Activate' }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">No records found</td>
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
