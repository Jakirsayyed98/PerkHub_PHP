<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminHomePageController;
use App\Http\Controllers\Admin\MiniAppCategoryController;
use App\Http\Controllers\Admin\MiniAppSubCategoryController;
use App\Http\Controllers\Admin\MiniAppController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\GamesController;
use App\Http\Controllers\Admin\LootOffersController;
use App\Http\Controllers\Admin\OfferController;

use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PostbackController;
use App\Http\Controllers\Admin\MiniAppTransactionController;
use App\Http\Controllers\Admin\CommisionSettingController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\LootProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/



Route::get('/', function () {
    return view('login');
});

//Admin
Route::get('/admin',[AdminHomePageController::class,'HomePage']);
Route::get('/Users',[AdminHomePageController::class,'UserListPage']);
Route::get('UserDelete',[AdminHomePageController::class,'UserDelete']);
Route::get('UserBlockUnBlock',[AdminHomePageController::class,'UserBlockUnBlock']);


//Categories
Route::get('/MiniAppCategoryList',[MiniAppCategoryController::class,'MiniAppcategoryList']);
Route::get('/AddOrUpdateCategories',[MiniAppCategoryController::class,'MiniAppcategoryAddorUpdate']);
Route::get('/DeleteCategorie',[MiniAppCategoryController::class,'DeleteCategoriesProcess']);
Route::post('/AddOrUpdateCategoriesProcess',[MiniAppCategoryController::class,'AddOrUpdateCategoriesProcessfun']);
Route::get('/ActiveDeactive',[MiniAppCategoryController::class,'ActiveDeactive']);
Route::get('/ActiveDeactivehomePageVis',[MiniAppCategoryController::class,'ActiveDeactivehomePageVis']);


//Sub Categories
Route::get('/MiniAppSubCategoryList',[MiniAppSubCategoryController::class,'MiniAppsubcategoryList']);
Route::get('/AddOrUpdateSubCategories',[MiniAppSubCategoryController::class,'MiniAppsubcategoryAddorUpdate']);
Route::get('/DeleteSubCategorie',[MiniAppSubCategoryController::class,'DeletesubCategoriesProcess']);
Route::post('/AddOrUpdateSubCategoriesProcess',[MiniAppSubCategoryController::class,'AddOrUpdatesubCategoriesProcessfun']);
Route::get('/SubcategoryActiveDeactive',[MiniAppSubCategoryController::class,'SubcategoryActiveDeactive']);


//Mini Apps
Route::get('/MiniAppList',[MiniAppController::class,'MiniAppList']);
Route::get('UpdateMiniApp',[MiniAppController::class,'UpdateMiniApps']);
Route::post('updateProcess',[MiniAppController::class,'updateProcessData']);
Route::get('deleteProcess',[MiniAppController::class,'deleteMiniApp']);
Route::get('miniAppActiveDeactive',[MiniAppController::class,'miniAppActiveDeactive']);
Route::get('popularActiveDeactive',[MiniAppController::class,'popularActiveDeactivefun']);
Route::get('trendingActiveDeactive',[MiniAppController::class,'trendingActiveDeactive']);
Route::get('top_cashbackActiveDeactive',[MiniAppController::class,'top_cashbackActiveDeactive']);
Route::get('ExportExcel',[MiniAppController::class,'ExportExcel']);
Route::get('AllMicroServiceUpdate',[MiniAppController::class,'AllMicroServiceUpdate']);


//Transaction
Route::get('MiniApptransaction',[MiniAppTransactionController::class,'MiniApptransaction']);
Route::post('UploadTxn',[MiniAppTransactionController::class,'UploadTxn']);
Route::get('UpdateMiniAppTxn',[MiniAppTransactionController::class,'UpdateMiniAppTxn']);
Route::get('BulkMiniAppTxn',[MiniAppTransactionController::class,'BulkMiniAppTxn']);


//Notifications
Route::get('adminnotificationlist',[NotificationsController::class,'adminnotificationlist']);
Route::get('CreateNotificationAndUpdate',[NotificationsController::class,'CreateNotificationAndUpdate']);
Route::post('createandupdatenotificationprocess',[NotificationsController::class,'createandupdatenotificationprocess']);
Route::get('deleteNotificationProcess',[NotificationsController::class,'deleteNotificationProcess']);
Route::get('sendAdminNotifications',[NotificationsController::class,'sendAdminNotifications']);


//Withdrawal
Route::get('WithdrawalList',[WithdrawalController::class,'WithdrawalList']);
Route::get('withdrawalstatusupdate',[WithdrawalController::class,'withdrawalstatusupdate']);
Route::post('withdrawalstatusupdateProcess',[WithdrawalController::class,'withdrawalstatusupdateProcess']);


//Banners
Route::get('bannerlist',[BannerController::class,'bannerlist']);
Route::get('AddAndUpdateBanner',[BannerController::class,'bannerAddOrUpdate']);
Route::get('deleteBanner',[BannerController::class,'deleteBanner']);
Route::get('ActiveDeactivebanner',[BannerController::class,'ActiveDeactivebanner']);
Route::post('AddOrUpdateBannerProcess',[BannerController::class,'AddOrUpdateBannerProcess']);

//Games 
Route::get('GamesCategoryList',[GamesController::class,'GamesCategoryList']);
Route::get('GamesSubCategoryList',[GamesController::class,'GamesSubCategoryList']);
Route::get('GamesList',[GamesController::class,'GamesList']);

Route::get('RefreshCategory',[GamesController::class,'RefreshCategory']);
Route::get('RefreshSubCategory',[GamesController::class,'RefreshSubCategory']);
Route::get('RefreshGames',[GamesController::class,'UpdateGameList']);
// Route::get('RefreshGames',[GamesController::class,'RefreshGames']);

Route::get('deleteGameCategory',[GamesController::class,'deleteGameCategory']);
Route::get('ActiveDeactiveGameCategory',[GamesController::class,'ActiveDeactiveGameCategory']);
Route::get('ActiveDeactiveGames',[GamesController::class,'ActiveDeactiveGames']);
Route::get('ActiveDeactivePopularGames',[GamesController::class,'ActiveDeactivePopularGames']);
Route::get('ActiveDeactiveTrendingGames',[GamesController::class,'ActiveDeactiveTrendingGames']);

Route::get('AddOrUpdateGameCategories',[GamesController::class,'AddOrUpdateGameCategories']);
Route::post('AddOrUpdateGameCategoriesProcess',[GamesController::class,'AddOrUpdateGameCategoriesProcess']);




Route::get('lootProductList',[LootProductController::class,'lootProductList']);
Route::get('AddOrUpdateLootProduct',[LootProductController::class,'LootProductAddOrUpdate']);
Route::post('AddOrUpdateLootProductProcess',[LootProductController::class,'LootProductAddOrUpdate']);






// Loot Offers
Route::get('lootOfferList',[LootOffersController::class,'lootOfferList']);
Route::get('AddOrUpdateLootOffers',[LootOffersController::class,'AddOrUpdateLootOffers']);
Route::get('DeleteLootOffers',[LootOffersController::class,'DeleteLootOffers']);
Route::get('ActivateDeactivateLootOffers',[LootOffersController::class,'ActivateDeactivateLootOffers']);
Route::post('updateLootOfferProcess',[LootOffersController::class,'updateLootOfferProcess']);


// Offer List
Route::get('offerlist',[OfferController::class,'offerlist']);
Route::get('AddOrUpdateOffer',[OfferController::class,'AddOrUpdateOffer']);
Route::post('ProcessAddOrUpdate',[OfferController::class,'ProcessAddOrUpdate']);
Route::get('deleteOfferProcess',[OfferController::class,'deleteOfferProcess']);
Route::get('OfferActiveDeactive',[OfferController::class,'OfferActiveDeactive']);


//Setting
Route::get('commision_setting',[CommisionSettingController::class,'CommisionSetting']);
Route::get('CommisionSettingAddOrUpdate',[CommisionSettingController::class,'CommisionSettingAddOrUpdate']);
Route::get('CommisionSettingAddOrUpdateProcess',[CommisionSettingController::class,'CommisionSettingAddOrUpdateProcess']);



Route::get('/cuelink/callback', 'App\Http\Controllers\Admin\CueLinkController@handleCallback');

