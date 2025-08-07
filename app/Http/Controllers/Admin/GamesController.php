<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use App\Models\GamesCategories;
use App\Models\Games;

class GamesController extends Controller
{
    //

    function UpdateGameList(Request $req){
        $data = Http::get('https://pub.gamezop.com/v3/games?id=4625');
        $result = json_decode($data->body());

        foreach($result->games as $item){
            $categoryId = 0;
            $category = (new GamesCategories)->GetCategoryByCategoryName($item->categories->en[0]);
           
            if($category){
                $categoryId = $category->id;
            }else{  
                $categoryName = $item->categories->en[0];
                $categoryId = (new GamesCategories)->SaveGameCategory($categoryName);
            }

            $game = (new Games)->GetGamesByGameCode($item->code);
            if ($game==null){
                $saveGame = (new Games)->SaveGame($item,$categoryId);
            }


        }
        
        return redirect('GamesList');
    }

    function GamesCategoryList(Request $req){
        $result = GamesCategories::paginate(10);
       
        return view('adminpanel/games/gamescategory',['records'=>$result]);
    }

    function AddOrUpdateGameCategories(Request $req){
        $id = $req->id;
        $category = GamesCategories::find($id);
       return view('adminpanel/games/addorupdatecategory',['records'=>$category]);
   }

    function GamesSubCategoryList(Request $req){
        return view('adminpanel/games/gamessubcategory');
    }

    function GamesList(Request $req){
        $result  =  Games::all();//paginate(10);
        for ($i=0; $i < $result->count() ; $i++) { 
            $result[$i]->assets = json_decode($result[$i]->assets);
        }
        $category = GamesCategories::all();
        return view('adminpanel/games/games',['response'=>$result,'category'=>$category]);
    }

    function AddOrUpdateGameCategoriesProcess(Request $req){
        $name  =  $req->name;
        $description  =  $req->description;
        $heading  =  $req->heading;
        $image  =  $req->image;

        $data =GamesCategories::find($req->id);

        if(is_null($data)){
            $result =new GamesCategories;
            $result->name = $name;
        $result->description = $description;
        $result->heading = $heading;
        $result->image = $image;
        $result->save();
        }else{
            $result =GamesCategories::find($req->id);
            $result->name = $name;
            $result->description = $description;
            $result->heading = $heading;
            $result->image =$data->image; 
            $result->save();
        }

        
        return redirect('GamesCategoryList');
    }


    function RefreshCategory(Request $req){
        
        $data = Http::get('https://pub.gamezop.com/v3/games?id=4625');
        $result = json_decode($data->body());
        foreach($result->games as $item){
            foreach($item->categories->en as $name){
                
                $checkExist = GamesCategories::where('name',$name)->get();
               
                if(count($checkExist)>0){
                
                }else{
                
                        $newdata = new GamesCategories;
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
            $result  =  Games::where('code',$item->code)->get();

            $category_id='';
                foreach($item->categories->en as $category){
                    $datas = GamesCategories::where('name',$category)->get();
                    $category_id = $datas[0]->id;
                }
                        // echo $category_id;
                        
            if(count($result)>0){

            }else{
                $data =  new Games;
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
        GamesCategories::where('id',$id)->delete();
        return redirect('GamesCategoryList');
    }
  
    function ActiveDeactiveGameCategory(Request $req){
        $category = GamesCategories::find($req->id);

        if($category->status=="1"){ 
            $category->status=  "0";
        } else {
            $category->status=  "1";
        };
        $category->save();

        return redirect('GamesCategoryList');
    }




    function ActiveDeactiveGames(Request $req){
        $games = Games::find($req->id);

        if($games->status=="1"){ 
            $games->status=  "0";
        } else {
            $games->status=  "1";
        };
        $games->save();

        return redirect('GamesList');
    }
  
    
    function ActiveDeactivePopularGames(Request $req){
        $games = Games::find($req->id);

        if($games->popular=="1"){ 
            $games->popular=  "0";
        } else {
            $games->popular=  "1";
        };
        $games->save();

        return redirect('GamesList');
    }
    
    
    function ActiveDeactiveTrendingGames(Request $req){
        $games = Games::find($req->id);

        if($games->trending=="1"){ 
            $games->trending=  "0";
        } else {
            $games->trending=  "1";
        };
        $games->save();

        return redirect('GamesList');
    }
}