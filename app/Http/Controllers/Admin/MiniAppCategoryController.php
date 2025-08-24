<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StoresCategories;
use App\Http\Controllers\Controller;

class MiniAppCategoryController extends Controller
{
    //

    function MiniAppcategoryList(Request $req){
        // $category = MiniAppCategoriesModel::all();
        $category = StoresCategories::paginate(10);
        return view('adminpanel/categories/miniAppcategory',['records'=>$category]);
    }

    function MiniAppcategoryAddorUpdate(Request $req){
         $id = $req->category_id;
         $category = StoresCategories::find($id);
        return view('adminpanel/categories/addOrEditCategories',['records'=>$category]);
    }
  
  
    

    function ActiveDeactive(Request $req){

        $id = $req->category_id;
        $category = StoresCategories::find($id);
        if($category->status=="1"){ 
            $category->status=  "0";
        } else {
            $category->status=  "1";
        };
        
        $category->save();

       return redirect('MiniAppCategoryList');
   }



   function ActiveDeactivehomePageVis(Request $req){
        $id = $req->category_id;
        $category = StoresCategories::find($id);
        if($category->homepage_visible=="1"){ 
            $category->homepage_visible=  "0";
        } else {
            $category->homepage_visible=  "1";
        };
        
        $category->save();

        return redirect('MiniAppCategoryList');
    }

    function AddOrUpdateCategoriesProcessfun(Request $req){

        $category = StoresCategories::find($req->id);


        if(is_null($category)){
            $name = $req->name;
        $description = $req->description;
        $categories =new StoresCategories;
        $categories->name =$name;
        $categories->homepage_visible = false;
        $categories->status = true;
        $categories->description =$description;
        // $categories->heading =$heading;
       
        if($req->hasfile('image')){
            $categories->image =$this->imageSave($req);
        }
        $result = $categories->save();
        return redirect('MiniAppCategoryList');  
        }else{
            $name = $req->name;
            $id = $req->id;
            $description = $req->description;
            $heading = $req->heading;
            $categories =StoresCategories::find($id);
            $categories->name =$name;
            $categories->description =$description;
            // $categories->heading =$heading;
           
            if($req->hasfile('image')){
                $categories->image =$this->imageSave($req);
            }
            $result = $categories->save();
            return redirect('MiniAppCategoryList');
        }
    }


    function DeleteCategoriesProcess(Request $req){
        $id = $req->category_id;
        $category = StoresCategories::find($id);
        $category->delete();
        return redirect('MiniAppCategoryList');   
    }
}