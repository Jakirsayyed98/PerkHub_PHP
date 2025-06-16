@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">


    <center>
        <h1>Games Sub Category</h1>
    </center>
    <ol class="breadcrumb float-sm-right">
        <form method="get">

            <button type="submit" formaction="AddAndUpdateBanner" class="btn btn-primary">+ Add new</button>
            <button type="submit" formaction="RefreshSubCategory" class="btn btn-primary">Refresh Sub-Category</button>
        </form>
    </ol>
    <center>
        <table class="table table-success table-striped " border="1 ">
            <thead bac>
                <tr style="background-color: black; color:white ">
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">url</th>
                    <th scope="col">image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>



        </table>

    </center>



    @endsection