<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashbaord</title>
</head>
<body>

    <center>
    <h1>Dashboard</h1>


 

 
<table  class="table table-success table-striped " border="1 ">
<thead bac>
<tr  style="background-color: black; color:white; height:50px">

  <th scope="col">name</th>
  <th scope="col">Available Count</th>

  <th scope="col">Action</th>
</tr>
</thead>

@if(isset($records))
<tr >
        <td style="width:450px"><center><h1>User Count</h1></center></td>
        <td style="width:300px"><center><h1>{{ $records->count() }}</h1></center></td>
        <td style="width:350px"><center><h3><a href="Users">Check User List</a></h3></center></td>
    </tr>

    <tr>
        <td style="width:250px"><center><h1>Mini App Category Count</h1></center></td>
        <td style="width:100px"><center><h1>{{ $category->count() }}</h1></center></td>
        <td style="width:250px"><center><h3><a href="MiniAppCategoryList">Check MiniApp Category List</a></h3></center></td>
    </tr>

    <tr>
        <td style="width:250px"><center><h1>Mini App Count</h1></center></td>
        <td style="width:100px"><center><h1>{{ $MiniAppData->count() }}</h1></center></td>
        <td style="width:250px"><center><h3><a href="MiniAppList">Check MiniApp List</a></h3></center></td>
    </tr>

@endif



</table> 
    </center>   



        
      

       



    <!-- @foreach ($records as $item)

        {{ $item->count() }}

    @endforeach -->

    

</body>
</html>