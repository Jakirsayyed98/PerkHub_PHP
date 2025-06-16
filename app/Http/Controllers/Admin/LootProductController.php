<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LootProduct;


class LootProductController extends Controller
{
    //

    public function LootProductList()
    {
        $products = (new LootProduct)->getAllProducts(); // Assuming you have a method to fetch all products
      
        return view('adminpanel/LootProducts/lootProductsList',['lootproducts'=>$products]);
    }


    public function LootProductAddOrUpdate(Request $req)
    {
        $product = (new LootProduct)->getProductById($req->id); // Assuming you have a method to fetch product by ID
        return view('adminpanel/LootProducts/lootProductForm',['records'=>$product]);
    }


    public function LootProductAddOrUpdateProcess(Request $req)
    {
        $product = (new LootProduct)->addOrUpdateProduct($req); // Assuming you have a method to add or update product
        if ($product) {
            return redirect()->route('LootProductList')->with('success', 'Product added/updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add/update product');
        }
    }
}
