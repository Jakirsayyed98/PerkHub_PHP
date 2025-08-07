<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;
    
    public function getAllGames()
    {
        return self::all();
    }

    public function getAllGamesByCategory($categoryId)
    {
        return self::where('category_id', $categoryId)->orWhere('status', "1")->get();
    }

    public function GetGamesByGameCode($gameCode)
    {
        return self::where('code', $gameCode)->first();
    }


    public function SaveGame($game,$categoryID){
        $gameObj = new self;
        $gameObj->code = $game->code;
        $gameObj->url = $game->url;
        $gameObj->isPortrait = $game->isPortrait;
        $gameObj->name = $game->name->en;
        $gameObj->description = $game->description->en;
        $gameObj->categoryId = $categoryID;
        $gameObj->gamePreviews = $game->gamePreviews->en;
        $gameObj->assets = json_encode($game->assets);
        $gameObj->width = $game->width;
        $gameObj->height = $game->height;
        $gameObj->colorMuted = $game->colorMuted;
        $gameObj->colorVibrant = $game->colorVibrant;
        $gameObj->privateAllowed = $game->privateAllowed;
        $gameObj->rating = $game->rating;
        $gameObj->numberOfRatings = $game->numberOfRatings;
        $gameObj->gamePlays = $game->gamePlays;
        $gameObj->hasIntegratedAds = $game->hasIntegratedAds;
        $gameObj->status = true;
        $gameObj->save();
        return ;
    }
}
