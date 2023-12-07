<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCheckout;
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

            $course = Course::find($request->course_name);
            if (!$course) throw new \Exception("Error, course not found");

            $courseInvoice = new CourseInvoice();
            $courseInvoice->user_id = Auth::user()->id;
            $courseInvoice->course_id = $course->id;
            $courseInvoice->code = "EIEN-". time() . rand(10, 998);
            $courseInvoice->name = Auth::user()->name;
            $courseInvoice->email = Auth::user()->email;
            $courseInvoice->amount = $request->amount;
            $courseInvoice->note = "Pembelian Kelas | ". $course->course_title ." | ". Carbon::now();
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
            $snapUrl = MidtransSnap::getSnapUrl($payload);

            $courseInvoice->snap_token = $snapToken;
            $courseInvoice->snap_url = $snapUrl;
            $courseInvoice->save();

            DB::commit();
            return response()->json(["snap_token" => $snapToken, "snap_url" => $snapUrl]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function finishPayment(Request $request) {
        try {
            DB::beginTransaction();

            $payment = CourseInvoice::where("code", $request->order_id)->first();

            if (!$payment) {
                throw new \Exception("Error, invoice not found");
            }
            if (!in_array(["200", "201"], $request->status)) {
                throw new \Exception("Error, pay invoice");
            }

            $payment->status = "Success";
            $payment->save();

            $checkout = new CourseCheckout();
            $checkout->note = "Berhasil melakukan pembelian kelas";
            $checkout->user_id = $payment->user_id;
            $checkout->course_id = $payment->course_id;
            $checkout->invoice_id = $payment->id;
            $checkout->save();

            DB::commit();

            return redirect()->route("user.dashboard");
        } catch (\Exception $e) {
            DB::rollBack();
            return abort(403);
        }
    }
}
