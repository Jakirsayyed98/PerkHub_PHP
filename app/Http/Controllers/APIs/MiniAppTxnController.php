<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MiniAppData;
use App\Models\MiniAppTransaction;
use App\Models\UserModel;
use App\Models\subid_data;

class MiniAppTxnController extends Controller
{

public function GenerateMiniAppSubId(Request $req) {
    $request = json_decode($req->getContent(), true);
    $user_id = $req->attributes->get('user_id');

    if (!isset($request['name'])) {
        return $this->sendResponse('1', [], 'Missing mini app name');
    }

    $user = (new UserModel)->getUserByUserId($user_id);
    if ($user && isset($user->id)) {
        $miniApp = (new MiniAppData)->getMiniAppByMiniAppNameOrId($request['name']);
        if ($miniApp && isset($miniApp->id)) {
            $miniAppId = $miniApp->id;
            $subid1 = $this->generateRandomValue(25);

            $delimiter = (parse_url($miniApp->url, PHP_URL_QUERY) == NULL) ? '?' : '&';
            $url = sprintf('%s%ssubid=%s&subid2=%s&subid3=%s', $miniApp->url, $delimiter, $subid1, $user_id, $miniAppId);

            $miniApp->url = $url;

            subid_data::InsertSubId($user_id, $miniAppId, $subid1);
            return $this->sendResponse('0', $url, 'Successfully');
        }
    }

    return $this->sendResponse('1', [], 'Error');
}


    /**
     * Get the list of mini app transactions for a user.
     *
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */

   public function getMiniAppTransactionList(Request $req)
{
    $request = json_decode($req->getContent(), true);
    $user_id = $req->attributes->get('user_id');

    $user = (new UserModel)->getUserByUserId($user_id);
    if (!$user || !isset($user->id)) {
        return $this->sendResponse('1', [], 'User not found');
    }

    $transactions =(new MiniAppTransaction)->GetMiniAppTransaction($user_id);
    if (!$transactions || $transactions->count() === 0) {
        return $this->sendResponse('1', [], 'No transactions found');
    }

    foreach ($transactions as $transaction) {
        $miniApp = (new MiniAppData)->getMiniAppByMiniAppNameOrId($transaction->miniapp_id);

        if ($miniApp) {
            $miniApp->icon = isset($miniApp->icon) ? asset('public/upload/images/' . $miniApp->icon) : '';
            $miniApp->logo = isset($miniApp->logo) ? asset('public/upload/images/' . $miniApp->logo) : '';
            $miniApp->banner = isset($miniApp->banner) ? asset('public/upload/images/' . $miniApp->banner) : '';

            $transaction->miniApp = [$miniApp];
        } else {
            $transaction->miniApp = [];
        }
    }

    return $this->sendResponse('0', $transactions, 'Transactions fetched successfully');
}

}
