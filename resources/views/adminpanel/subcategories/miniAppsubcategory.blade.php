@extends('adminpanel.layout.main')
@section('main-container')

<div class="content-wrapper">

<center><h1>MiniApp Sub-Categorys List</h1></center>
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

<form action="AddOrUpdateSubCategories" method="get">

<button type="submit" value="0" name="id" class="btn btn-primary" style="margin-right:15px;">+ Add new</button>
</form>


</ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


    <div class="card">
    <div class="card-body">

        <table id="example1" class="table table-bordered table-striped">
            <thead bac>
                <tr >
      <th scope="col">id</th>
      <th scope="col">name</th>
      <th scope="col">Category name</th>
      <th scope="col">image</th>
      <!-- <th scope="col">status</th> -->
      <th scope="col">description</th>
      <th scope="col">heading</th>
      <th scope="col">Action</th>
    </tr>
  </thead>

  @if(isset($records))
  @foreach($records as $item)

    <tr>
    <th  scope="row">{{$item->id}}</th>
    <form method="get">
    <input type="hidden" name="category_id" value="{{$item->id}}">
      <td ><center>{{$item->name}}</center></td>

      @foreach($category as $cat_item)
      @if($item->category_id == $cat_item->id)
      <td ><center>{{$cat_item->name}}</center></td>
      @endif
      @endforeach

      <td ><center><img src="{{ asset('upload/images/'.$item->image) }}" width="70px" height="70px"></img></center></td>
      <!-- <td ><center>{{$item->status}}</center></td> -->
      <td ><center>{{$item->description}}</center></td>
      <td ><center>{{$item->heading}}</center></td>

      <td scope="col">
        
      
       
      <button type="submit" formaction="AddOrUpdateSubCategories" class="btn btn-primary"  name="Update" value="{{$item->id}}">Update</button>
      <button style="margin-left:15px;background-color:red" formaction="DeleteSubCategorie" class="btn btn-primary" type="Delete" value="{{$item->id}}">Delete</button>
      <button style="margin-left:15px;background-color:red" formaction="SubcategoryActiveDeactive" class="btn btn-primary" type="submit" value="{{$item->id}}">{{$item->status == '1' ? 'Deactive' : 'Active'}}</button>
      
    
    
      </td>

      </form>
    </tr>

  @endforeach

  @endif



  </table>

</div>
</div>

</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>


@endsection