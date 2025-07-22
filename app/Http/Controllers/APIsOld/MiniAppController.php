<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MiniAppData;
use App\Models\UserModel;
use Validator;

class MiniAppController extends Controller
{
    //
    function searchMiniApp(Request $req){
       

        $validator = Validator::make($req->all(),[
            'user_id'=>'required',
            'miniapp_name'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendResponse('1',[],$validator->errors()->first());
            
        }
        $data = $req->miniapp_name;
        $user_id = $req->user_id;

        $user = UserModel::where('id',$user_id)->get();
        
        if($user->count()>0){
            if($data=='all'){
                $result = MiniAppData::where('status','1')->get();
            }else{
                $result = MiniAppData::where('name','like','%'.$data.'%')->where('status','1')->orwhere('id',$data)->get();
            }
            
            
            if($result){
                for ($i=0; $i < $result->count() ; $i++) { 
                    if(isset($result[$i]->icon)){
                        $result[$i]->icon = $this->getImageWithUrl($result[$i]->icon);
                    }else{
                        $result[$i]->icon ='';
                    }
    
                    if(isset($result[$i]->logo)){
                        $result[$i]->logo = $this->getImageWithUrl($result[$i]->logo);
                    }else{
                        $result[$i]->logo ='';
                    }
    
                    if(isset($result[$i]->banner)){
                        $result[$i]->banner = $this->getImageWithUrl($result[$i]->banner);
                    }else{
                        $result[$i]->banner ='';
                    }
    
    
    
                    // $result[$i]->icon ='';
    
                }
                $response = $result;
                return $this->sendResponse('0',$response,'Successfully');
            }else{
                $response = [];
                return $this->sendResponse('1',$response,'MiniApp not found');
            }
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'User not found');
        }

        

    }

    function getMiniAppByCategory(Request $req){
        $user_id = $req->attributes->get('user_id');
        $user = (new UserModel)->getUserByUserId($user_id);
        
        if($user->count()>0){

        $category_id = $req->category_id;
       
        $result = (new MiniAppData)->getMiniAppByCategoryID($category_id);

        if($result){
            for ($i=0; $i < $result->count() ; $i++) { 
                if(isset($result[$i]->icon)){
                    $result[$i]->icon =$this->getImageWithUrl($result[$i]->icon);
                }else{
                    $result[$i]->icon ='';
                }

                if(isset($result[$i]->logo)){
                    $result[$i]->logo = $this->getImageWithUrl($result[$i]->logo);
                }else{
                    $result[$i]->logo ='';
                }

                if(isset($result[$i]->banner)){
                    $result[$i]->banner = $this->getImageWithUrl($result[$i]->banner);
                }else{
                    $result[$i]->banner ='';
                }
            }
            $response = $result;
            return $this->sendResponse('0',$response,'Successfully');
        }else{
            $response = [];
            return $this->sendResponse('1',$response,'MiniApp not found');
        }

    }else{
        $response = [];
        return $this->sendResponse('1',$response,'User not found');
    }
    }
}
