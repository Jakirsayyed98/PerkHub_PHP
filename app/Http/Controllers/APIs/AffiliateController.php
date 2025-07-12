<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\MiniAppTransaction;
use App\Models\UserModel;
use App\Models\subid_data;



class AffiliateController extends Controller
{
   public function CueLinkCallback(Request $request)
{
    // Extract & sanitize query parameters
    $campaign_id        = $request->query('campaign_id');
    $commission         = floatval($request->query('commission', 0));
    $reference_id       = $request->query('reference_id');
    $sale_amount        = floatval($request->query('sale_amount', 0));
    $status             = $request->query('status', 'pending');
    $subid              = $request->query('subid');
    $subid1             = $request->query('subid1');
    $subid2             = $request->query('subid2'); // user_id
    $subid3             = $request->query('subid3');
    $transaction_date   = $request->query('transaction_date') ?? now();
    $transaction_id     = $request->query('transaction_id');

    // Fetch miniapp_id from subid_data
    $subIdData = subid_data::getDataBySubId($subid);
    if (!$subIdData) {
        return $this->SendErrorResponse('1', [], 'SubId not found.');
    }

    $miniapp_id = $subIdData->brand_id ?? null;

    // Calculate user commission (70% of total commission)
    $user_commission = $this->CalculateUserCommission($commission, "70%");
    $commission_percentage = "70%"; // optional, hardcoded for now

    // Save or update the transaction
    MiniAppTransaction::saveOrUpdateByUserSubid(
        transactionId: $transaction_id,
        userId: $subid2,
        campaignId: $campaign_id,
        miniAppId: $miniapp_id,
        commission: $commission,
        userCommission: $user_commission,
        subid: $subid,
        subid1: $subid1,
        subid2: $subid2,
        subid3: $subid3,
        saleAmount: $sale_amount,
        commissionPercentage: $commission_percentage,
        transactionAmt: $sale_amount,
        transactionDate: $transaction_date,
        transactionStatus: $this->getStatusCode($status),
        referenceId: $reference_id
    );

    return $this->SendSuccessResponse('0', [], 'Callback received successfully');
}

    public function CalculateUserCommission($commission, $commission_percentage) {
        $commission = str_replace('%', '', $commission);
        $commission_percentage = str_replace('%', '', $commission_percentage);
        $user_commission = ($commission * $commission_percentage) / 100;
        return number_format($user_commission, 2);
    }

    public function getStatusCode(string $status): string{
        $status = strtolower(trim($status)); // normalize input

        switch ($status) {
            case 'pending':
                return "0";
            case 'validated':
            case 'verified':
                return "1";
            case 'rejected':
                return "2";
            default:
                return "0";
        }

    }

}

