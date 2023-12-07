<?php

namespace App\Http\Controllers;

use App\Models\CourseInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap as MidtransSnap;

class PaymentController extends Controller
{
    public function __construct() {
        MidtransConfig::$serverKey    = config('services.midtrans.serverKey');
        MidtransConfig::$isProduction = config('services.midtrans.isProduction');
        MidtransConfig::$isSanitized  = config('services.midtrans.isSanitized');
        MidtransConfig::$is3ds        = config('services.midtrans.is3ds');
    }

    public function payCourse(Request $request) {
        try {
            DB::beginTransaction();

            $courseInvoice = new CourseInvoice();
            $courseInvoice->code = "EIEN-". time() . rand(10, 998);
            $courseInvoice->name = Auth::user()->name;
            $courseInvoice->email = Auth::user()->email;
            $courseInvoice->amount = $request->amount;
            $courseInvoice->note = "Pembelian Kelas | ". $request->course_name ." | ". Carbon::now();
            $courseInvoice->save();

            $payload = [
                "transaction_details" => [
                    "order_id"     => $courseInvoice->code,
                    "gross_amount" => $courseInvoice->amount,
                ],
                "customer_details" => [
                    "first_name" => $courseInvoice->name,
                    "email"      => $courseInvoice->email,
                ],
                "item_details" => [
                    [
                        "id"            => $courseInvoice->code,
                        "price"         => $courseInvoice->amount,
                        "quantity"      => 1,
                        "name"          => "Pembelian Kelas " . $request->course_name,
                        "brand"         => "Edukasi",
                        "category"      => "Kelas Onlne",
                        "merchant_name" => "Edukasi 4.0",
                    ],
                ],
            ];
            $snapToken = MidtransSnap::getSnapToken($payload);

            $courseInvoice->snap_token = $snapToken;
            $courseInvoice->save();

            DB::commit();
            return response()->json(["snap_token" => $snapToken]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
