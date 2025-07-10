<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\APIs\UserAuthController;
use App\Http\Controllers\APIs\MiniAppTxnController;
use App\Http\Controllers\APIs\WithdrawalController;
use App\Http\Controllers\APIs\HomePageController;
use App\Http\Controllers\APIs\AffiliateController;
use App\Http\Controllers\APIs\NotificationController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Login APIs

Route::post('/sendOTP','App\Http\Controllers\APIs\UserAuthController@sendOTPtoUser');
Route::post('/authorization','App\Http\Controllers\APIs\UserAuthController@authorization');
Route::post('/verifyOTP','App\Http\Controllers\APIs\UserAuthController@verifyOTP');

Route::middleware(['user_auth'])->group(function(){
    Route::post('/savedetail','App\Http\Controllers\APIs\UserAuthController@saveUserdetail');
    Route::post('/updateNotificationToken','App\Http\Controllers\APIs\UserAuthController@updateNotificationToken');
    Route::get('/getUserDetail','App\Http\Controllers\APIs\UserAuthController@getUserDetails');
    Route::get('/getHomePage','App\Http\Controllers\APIs\HomePageController@getHomePage');
});


//MiniApp Related APIs
Route::middleware(['user_auth'])->group(function(){
    Route::post('/generate-sub-id',[MiniAppTxnController::class, 'GenerateMiniAppSubId']);
    Route::post('/searchMiniApps','App\Http\Controllers\APIs\MiniAppController@searchMiniApp');
    Route::post('/getMiniAppByCategory','App\Http\Controllers\APIs\MiniAppController@getMiniAppByCategory');
});


//User Transaction and Withdrawal Related APIs
Route::middleware(['user_auth'])->group(function(){
    Route::GET('/withdrawal/txnList',[WithdrawalController::class, 'getWithdrawalTxnList']);
    Route::post('/withdrawal/request','App\Http\Controllers\APIs\WithdrawalController@requestwithdrawal');
});

Route::post('/admin/cuelink-callback',[AffiliateController::class, 'CueLinkCallback']);

Route::post('/sendNotification',[NotificationController::class,'sendNotification']);



//Games Related APIs
Route::middleware(['user_auth'])->group(function(){
    Route::GET('/getgames-categories','App\Http\Controllers\APIs\GamesController@getAllCategory');
    Route::post('/getAllGames','App\Http\Controllers\APIs\GamesController@getAllGames');
    Route::post('/search-game','App\Http\Controllers\APIs\GamesController@searchGames');
    Route::GET('/get-popular-games','App\Http\Controllers\APIs\GamesController@PopularGames');
    Route::GET('/get-trending-games','App\Http\Controllers\APIs\GamesController@TrendingGames');
});

//Notification
Route::middleware(['user_auth'])->group(function(){
Route::GET('/getNotificationList','App\Http\Controllers\APIs\NotificationController@getNotificationList');
});

//Withdrawal 

// Home Page
// Route::post('/getHomePage','App\Http\Controllers\APIs\HomePageController@getHomePage');
Route::middleware(['user_auth'])->group(function(){
Route::post('/UpdateTXN','App\Http\Controllers\APIs\MiniAppTxnController@UpdateTxnDetail');
Route::post('/getTxnList',[MiniAppTxnController::class, 'getMiniAppTransactionList']);
});


//MiniApp Controls


//Loot Offers
//Games Related APIs
Route::middleware(['user_auth'])->group(function(){
Route::post('/getAllLootoffers','App\Http\Controllers\APIs\LootOffersController@getAllLootoffers');
Route::post('searchLootoffers','App\Http\Controllers\APIs\LootOffersController@searchLootoffers');
});




//Offers
Route::middleware(['user_auth'])->group(function(){
    Route::post('getOfferList','App\Http\Controllers\APIs\OfferController@getAllOffers');
});



