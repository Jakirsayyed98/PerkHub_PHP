<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use App\Models\games_categories;
use App\Models\games;

class GamesController extends Controller
{
    //

    function UpdateGameList(Request $req){
        $data = Http::get('https://pub.gamezop.com/v3/games?id=4625');
        $result = json_decode($data->body());

        foreach($result->games as $item){
            $categoryId = 0;
            $category = (new games_categories)->GetCategoryByCategoryName($item->categories->en[0]);
           
            if($category){
                $categoryId = $category->id;
            }else{  
                $categoryName = $item->categories->en[0];
                $categoryId = (new games_categories)->SaveGameCategory($categoryName);
            }

            $game = (new games)->GetGamesByGameCode($item->code);
            if ($game==null){
                $saveGame = (new games)->SaveGame($item,$categoryId);
            }


        }
        
        return redirect('GamesList');
    }

    function GamesCategoryList(Request $req){
        $result = games_categories::paginate(10);
       
        return view('adminpanel/games/gamescategory',['records'=>$result]);
    }

    function AddOrUpdateGameCategories(Request $req){
        $id = $req->id;
        $category = games_categories::find($id);
       return view('adminpanel/games/addorupdatecategory',['records'=>$category]);
   }

    function GamesSubCategoryList(Request $req){
        return view('adminpanel/games/gamessubcategory');
    }

    function GamesList(Request $req){
        $result  =  games::all();//paginate(10);
        for ($i=0; $i < $result->count() ; $i++) { 
            $result[$i]->assets = json_decode($result[$i]->assets);
        }
        $category = games_categories::all();
        return view('adminpanel/games/games',['response'=>$result,'category'=>$category]);
    }

    function AddOrUpdateGameCategoriesProcess(Request $req){
        $name  =  $req->name;
        $description  =  $req->description;
        $heading  =  $req->heading;

        $data =games_categories::find($req->id);

        if(is_null($data)){
            $result =new games_categories;
            $result->name = $name;
        $result->description = $description;
        $result->heading = $heading;

        if($req->hasfile('image')){
            $file = $req->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().".".$extention;
            $file->move('upload/images/',$filename);
            $result->image =$filename;
        }
       
        $result->save();
        }else{
            $result =games_categories::find($req->id);
            $result->name = $name;
            $result->description = $description;
            $result->heading = $heading;
    
            if($req->hasfile('image')){
                $file = $req->file('image');
                $extention = $file->getClientOriginalExtension();
                $filename = time().".".$extention;
                $file->move('upload/images/',$filename);
                $result->image =$filename;
            }
           
            $result->save();
        }

        
        return redirect('GamesCategoryList');
    }


    function RefreshCategory(Request $req){
        
        $data = Http::get('https://pub.gamezop.com/v3/games?id=4625');
        $result = json_decode($data->body());
        foreach($result->games as $item){
            foreach($item->categories->en as $name){
                
                $checkExist = games_categories::where('name',$name)->get();
               
                if(count($checkExist)>0){
                
                }else{
                
                        $newdata = new games_categories;
                        $newdata->name = $name;
                        $newdata->save();
                }
            }
           
        }
       
        return redirect('GamesCategoryList');
       
        // return view('adminpanel/games/gamescategory');
    }

    function RefreshSubCategory(Request $req){
        return view('adminpanel/games/gamessubcategory');
    }

    function RefreshGames(Request $req){

        $response = Http::get('https://pub.gamezop.com/v3/games?id=4625');
        $result = json_decode($response->body());
        foreach($result->games as $item){
            $result  =  games::where('code',$item->code)->get();

            $category_id='';
                foreach($item->categories->en as $category){
                    $datas = games_categories::where('name',$category)->get();
                    $category_id = $datas[0]->id;
                }
                        // echo $category_id;
                        
            if(count($result)>0){

            }else{
                $data =  new games;
                $data->code = $item->code;
                $data->url = $item->url;
                $data->name = $item->name->en;
                $data->isPortrait = $item->isPortrait;
                $data->description = $item->description->en;
                $data->gamePreviews = $item->gamePreviews->en;
                $data->assets = json_encode($item->assets);
                $data->width = $item->width;
                $data->height = $item->height;                                                                                                                                                                                                                                                                                                                                                              
                $data->colorMuted = $item->colorMuted;
                $data->colorVibrant = $item->colorVibrant;
                $data->privateAllowed = $item->privateAllowed;
                $data->rating = $item->rating;
                $data->category_id = $category_id;
                $data->numberOfRatings = $item->numberOfRatings;
                $data->gamePlays = $item->gamePlays;
                $data->hasIntegratedAds = $item->hasIntegratedAds;
                $data->save();
            }

           
           
        }


        return redirect('GamesList');
       
        //return view('adminpanel/games/games');
    }


    function deleteGameCategory(Request $req){
        $id = $req->id;
        games_categories::where('id',$id)->delete();
        return redirect('GamesCategoryList');
    }
  
    function ActiveDeactiveGameCategory(Request $req){
        $category = games_categories::find($req->id);

        if($category->status=="1"){ 
            $category->status=  "0";
        } else {
            $category->status=  "1";
        };
        $category->save();

        return redirect('GamesCategoryList');
    }




    function ActiveDeactiveGames(Request $req){
        $games = games::find($req->id);

        if($games->status=="1"){ 
            $games->status=  "0";
        } else {
            $games->status=  "1";
        };
        $games->save();

        return redirect('GamesList');
    }
  
    
    function ActiveDeactivePopularGames(Request $req){
        $games = games::find($req->id);

        if($games->popular=="1"){ 
            $games->popular=  "0";
        } else {
            $games->popular=  "1";
        };
        $games->save();

        return redirect('GamesList');
    }
    
    
    function ActiveDeactiveTrendingGames(Request $req){
        $games = games::find($req->id);

        if($games->trending=="1"){ 
            $games->trending=  "0";
        } else {
            $games->trending=  "1";
        };
        $games->save();

        return redirect('GamesList');
    }
}