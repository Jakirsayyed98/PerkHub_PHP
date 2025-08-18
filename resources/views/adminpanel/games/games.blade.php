@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Games</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <form method="get" class="d-inline">
                        <button type="submit" formaction="RefreshGames" class="btn btn-info">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </form>
                    <a href="{{ url('AddAndUpdateBanner') }}" class="btn btn-success ml-2">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Name</th>
                                <th style="width: 120px;">Icon</th>
                                <th>Category</th>
                                <th style="width: 120px;">Code</th>
                                <th style="width: 280px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($response) && count($response) > 0)
                                @foreach($response as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td class="text-center">{{ $item->name }}</td>
                                        <td class="text-center">
                                            <img src="{{ $item->assets->thumb }}" class="img-thumbnail" width="80" height="60" alt="Game Icon">
                                        </td>
                                        <td class="text-center">
                                            @foreach($category as $cat_item)
                                                @if($item->category_id == $cat_item->id)
                                                    <span class="badge badge-primary">{{ $cat_item->name }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-center"><code>{{ $item->code }}</code></td>
                                        <td>
                                            <form method="get" class="d-inline">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button formaction="ActiveDeactiveGames" class="btn btn-sm btn-{{ $item->status == '1' ? 'danger' : 'success' }}">
                                                    <i class="fas fa-toggle-{{ $item->status == '1' ? 'off' : 'on' }}"></i>
                                                    {{ $item->status == '1' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                            <form method="get" class="d-inline">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button formaction="ActiveDeactivePopularGames" class="btn btn-sm btn-{{ $item->popular == '1' ? 'warning' : 'secondary' }}">
                                                    <i class="fas fa-star"></i>
                                                    {{ $item->popular == '1' ? 'Un-Popular' : 'Popular' }}
                                                </button>
                                            </form>

                                            <form method="get" class="d-inline">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button formaction="ActiveDeactiveTrendingGames" class="btn btn-sm btn-{{ $item->trending == '1' ? 'info' : 'secondary' }}">
                                                    <i class="fas fa-fire"></i>
                                                    {{ $item->trending == '1' ? 'Un-Trending' : 'Trending' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No games found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
