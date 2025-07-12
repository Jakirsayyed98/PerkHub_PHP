<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\MiniAppCategoriesModel;
use App\Models\MiniAppData;
use App\Http\Controllers\Controller;
use App\Models\MiniAppTransaction;
use App\Models\WithdrawalRequest;
use App\Models\games_categories;
use App\Models\games;

class AdminHomePageController extends Controller
{
    //

    function HomePage(Request $req){
        
        $userlist = (new UserModel)->getAllUsers();
        if (!$userlist) {
            return back()->with('error', 'No users found.');
        }    
        $miniapp = (new MiniAppData)->getAllMiniApps();
        $category = MiniAppCategoriesModel::all();
        $transactions = MiniAppTransaction::all();
        $withdrawalRes = (new WithdrawalRequest)->getByStatus("0");
        $games = games::all();
        $GamesCate = games_categories::all();
        return view('adminpanel/adminhome',['records'=>$userlist,'MiniAppData'=>$miniapp,'category'=>$category,
        'transactions'=>$transactions,'withdrawalRes'=>$withdrawalRes,'Games'=>$games,'GamesCate'=>$GamesCate]);
    }

    function UserListPage(Request $req){
        $userlist = UserModel::paginate(10);
        return view('adminpanel/UserList',['records'=>$userlist]);
    }

    function UserDelete(Request $req){
        UserModel::find($req->id)->delete();
        return redirect('Users');
    }

    function UserBlockUnBlock(Request $req) {
        $userdata = UserModel::find($req->id);
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
