<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\games_categories;
use App\Models\games;
use Validator;
use App\Models\UserModel;

class GamesController extends Controller
{
    //
    function getAllCategory(Request $req){
        $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
    
        $user =(new UserModel)->getUserByUserId($user_id);
        if($user->count()>0){
        $result = games_categories::where('status','1')->get();
        if($result){

           for ($i=0; $i < $result->count(); $i++) { 
            if ($result[$i]->image != null){
                $result[$i]->image=asset('upload/images/'.$result[$i]->image); 
            }else{
                $result[$i]->image = "";
            }
           }
           
            $response = $result;

            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Category not found');
        }

        }else{
            $response = [];
            return $this->sendResponse('1',$response,'User not found');
        }

    }

    function getAllGames(Request $req){
        //  $request = json_decode($req->getContent(), true);
        $user_id = $req->attributes->get('user_id');
    
        $user = UserModel::where('user_id',$user_id)->get();
        if($user->count()>0){
        $result = games::where('status','1')->get();
        if($result){

            for ($i=0; $i < $result->count() ; $i++) { 
                $result[$i]->assets = json_decode($result[$i]->assets);
            }

            $response = $result;
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Category not found');
        }
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'User not found');
        }
    }

    function searchGames(Request $req) {
        $user_id = $req->attributes->get('user_id');
    
        $user = UserModel::where('user_id',$user_id)->get();
        if($user->count()>0){
        $result = games::where('name','like','%'.$req->name . '%')->get();
        if($result){
            for ($i=0; $i < $result->count() ; $i++) { 
                $result[$i]->assets = json_decode($result[$i]->assets);
            }
            $response = $result;
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Category not found');
        }
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'User not found');
        }
    }

    function PopularGames(Request $req) {
        $user_id = $req->attributes->get('user_id');
    
        $user = UserModel::where('user_id',$user_id)->get();
        if($user->count()>0){
        $result = games::where('popular','1')->get();
        if($result){
            for ($i=0; $i < $result->count() ; $i++) { 
                $result[$i]->assets = json_decode($result[$i]->assets);
            }
            $response = $result;
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Category not found');
        }

        }else{
            $response = [];
            return $this->sendResponse('1',$response,'User not found');
        }
    }

    function TrendingGames(Request $req) {
        $user_id = $req->attributes->get('user_id');
    
        $user = UserModel::where('user_id',$user_id)->get();
        if($user->count()>0){
        $result = games::where('trending','1')->get();
        if($result){
            for ($i=0; $i < $result->count() ; $i++) { 
                $result[$i]->assets = json_decode($result[$i]->assets);
            }
            $response = $result;
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'Category not found');
        }

        }else{
            $response = [];
            return $this->sendResponse('1',$response,'User not found');
        }
    }
    
}
