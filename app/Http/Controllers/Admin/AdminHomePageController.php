<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MiniAppCategoriesModel;
use App\Models\Store;
use App\Models\StoresCategories;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\WithdrawalRequest;
use App\Models\GamesCategories;
use App\Models\Games;

class AdminHomePageController extends Controller
{
    //

    function HomePage(Request $req){
        
        $userlist = (new User)->getAllUsers();
        if (!$userlist) {
            return back()->with('error', 'No users found.');
        }    
        $miniapp = (new Store)->getAllStores();
        $category = (new StoresCategories)->getAllCategories();
        $transactions =(new Order)->getAllOrders();
        $withdrawalRes = (new WithdrawalRequest)->getAllPendingWithdrawals();
        $games = (new Games)->getAllGames();
        $GamesCate = (new GamesCategories)->getAllGameCategories();
        return view('adminpanel/adminhome',['records'=>$userlist,'MiniAppData'=>$miniapp,'category'=>$category,
        'transactions'=>$transactions,'withdrawalRes'=>$withdrawalRes,'Games'=>$games,'GamesCate'=>$GamesCate]);
    }

    function UserListPage(Request $req){
        $userlist = User::paginate(10);
        return view('adminpanel/UserList',['records'=>$userlist]);
    }

    function UserDelete(Request $req){
        User::find($req->id)->delete();
        return redirect('Users');
    }

    function UserBlockUnBlock(Request $req) {
        $userdata = User::find($req->id);
        if($userdata->status=="2"){
            $userdata->status="1";
        }else if($userdata->status=="1"){
            $userdata->status="2";
        }else{
            
        }
        
        $userdata->save();
        return redirect('Users');
    }
   


}
