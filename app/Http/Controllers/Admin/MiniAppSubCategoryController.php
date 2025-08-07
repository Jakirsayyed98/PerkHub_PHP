<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\miniapp_subcategoriesModel;
use App\Models\MiniAppCategoriesModel;

class MiniAppSubCategoryController extends Controller
{
    //

    function MiniAppsubcategoryList(Request $req){
        $subcategory = miniapp_subcategoriesModel::paginate(10);
        $category = MiniAppCategoriesModel::all();

        return view('adminpanel/subcategories/miniAppsubcategory',['records'=>$subcategory,'category'=>$category]);
    }

    function MiniAppsubcategoryAddorUpdate(Request $req){

         $id = $req->category_id;
         
         $subcategory = miniapp_subcategoriesModel::find($id);
         $category = MiniAppCategoriesModel::all();
// echo "<pre>";
//         print_r($subcategory);
//         die;
        return view('adminpanel/subcategories/addOrEditsubCategories',['records'=>$subcategory,'category'=>$category]);
    }


    function AddOrUpdatesubCategoriesProcessfun(Request $req){
       
        $subcategory_data = miniapp_subcategoriesModel::find($req->id);
        // echo "<pre>";
        // print_r($req->all());
        // die;

        if(is_null($subcategory_data)){
            $name = $req->name;
        $description = $req->description;
        $heading = $req->heading;
        $subcategories =new miniapp_subcategoriesModel;
        $subcategories->name =$name;
        $subcategories->description =$description;
        $subcategories->heading =$heading;
        $subcategories->category_id=$req->category_id;
        $subcategories->category_name=$req->category_name;
        if($req->hasfile('image')){
            $file = $req->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().".".$extention;
            $file->move('upload/images/',$filename);
            $subcategories->image =$filename;
        }
        $result = $subcategories->save();
        return redirect('MiniAppSubCategoryList');  
        }else{
            $name = $req->name;
            $id = $req->id;
            $description = $req->description;
            $heading = $req->heading;
            $subcategories =miniapp_subcategoriesModel::find($id);
            $subcategories->name =$name;
            $subcategories->description =$description;
            $subcategories->heading =$heading;
            $subcategories->category_id=$req->category_id;
            $subcategories->category_name=$req->category_name;
            if($req->hasfile('image')){
                $file = $req->file('image');
                $extention = $file->getClientOriginalExtension();
                $filename = time().".".$extention;
                $file->move('upload/images/',$filename);
                $subcategories->image =$filename;
            }
            $result = $subcategories->save();
            return redirect('MiniAppSubCategoryList');
        }
    }

    function SubcategoryActiveDeactive(Request $req){

        $id = $req->category_id;
        $sub_category = miniapp_subcategoriesModel::find($id);
        if($sub_category->status=="1"){ 
            $sub_category->status=  "0";
        } else {
            $sub_category->status=  "1";
        };
        
        $sub_category->save();

       return redirect('MiniAppSubCategoryList');
   }



    function DeletesubCategoriesProcess(Request $req){
    
        $id = $req->category_id;
        $category = miniapp_subcategoriesModel::find($id);
        $category->delete();
        return redirect('MiniAppSubCategoryList');   
    }

    
}
