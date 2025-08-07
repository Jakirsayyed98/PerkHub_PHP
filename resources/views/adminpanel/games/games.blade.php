@extends('adminpanel.layout.main')

@section('main-container')

<div class="content-wrapper">

    <center>
        <h1>Games</h1>
    </center>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- Left column if needed -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <form method="get">
                            <button type="submit" formaction="AddAndUpdateBanner" class="btn btn-primary">+ Add new</button>
                            <button type="submit" formaction="RefreshGames" class="btn btn-primary">Refresh Games</button>
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
                                        <th scope="col">Icon</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($response))
                                        @foreach($response as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td class="text-center">{{ $item->name }}</td>
                                                <td class="text-center">
                                                    <img src="{{ $item->assets->thumb }}" width="90px" height="70px" alt="Game Icon">
                                                </td>
                                                <td class="text-center">
                                                    @foreach($category as $cat_item)
                                                        @if($item->category_id == $cat_item->id)
                                                            {{ $cat_item->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="text-center">{{ $item->code }}</td>
                                                <td>
                                                    <form method="get">
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <button formaction="ActiveDeactiveGames" class="btn btn-danger mb-1" type="submit">
                                                            {{ $item->status == '1' ? 'Deactive' : 'Active' }}
                                                        </button>
                                                        <button formaction="ActiveDeactivePopularGames" class="btn btn-warning mb-1" type="submit">
                                                            {{ $item->popular == '1' ? 'Un-Popular' : 'Popular' }}
                                                        </button>
                                                        <button formaction="ActiveDeactiveTrendingGames" class="btn btn-info" type="submit">
                                                            {{ $item->trending == '1' ? 'Un-Trending' : 'Trending' }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
