<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCheckout;
use App\Models\CourseInvoice;
use App\Models\InstructorWallet;
use App\Models\MentoringCheckout;
use App\Models\MentoringInvoice;
use App\Models\SalesFee;
use App\Models\ScheduleMentoring;
use App\Models\WalletLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap as MidtransSnap;
use Midtrans\Transaction as MidtransTransaction;

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
            if ($payment) {
                if (!in_array($request->status_code, ["200", "201"])) {
                    throw new \Exception("Error, pay invoice");
                }

                $payment->status = "Success";
                $payment->save();

                $course = Course::find($payment->course_id);
                if (!$course) throw new \Exception("Error, course not found");

                $wallet = InstructorWallet::where("user_id", $course->user_id)->where("type", "Primary")->first();
                if (!$wallet) throw new \Exception("Error, wallet not found");

                $salesRate = SalesFee::where("id", 1)->first();
                $income = 0;

                if ($salesRate->type == "percentage") {
                    $income = $payment->amount - ($payment->amount * $salesRate->value / 100);
                }
                if ($salesRate->type == "fixed") {
                    $income = $payment->amount - ($payment->amount - $salesRate->value);
                }

                $walletLog = new WalletLog();
                $walletLog->from_table_wallet = "instructor_wallets";
                $walletLog->from_table_wallet_id = $wallet->id;
                $walletLog->from_table_invoice = "course_invoices";
                $walletLog->from_table_invoice_id = $payment->id;
                $walletLog->invoice_amount = $payment->amount;
                $walletLog->income = $income;
                $walletLog->wallet_balance_current = $wallet->balance;
                $walletLog->wallet_balance = $wallet->balance + $income;
                $walletLog->remarks = "Pendapatan dari penjualan (". $course->course_title .")";
                $walletLog->save();

                $wallet->balance = $wallet->balance + $walletLog->income;
                $wallet->save();

                $checkout = new CourseCheckout();
                $checkout->note = "Berhasil melakukan pembelian kelas";
                $checkout->user_id = $payment->user_id;
                $checkout->course_id = $payment->course_id;
                $checkout->invoice_id = $payment->id;
                $checkout->save();

                DB::commit();
                return redirect()->route("user.class");
            }

            $paymentMentoring = MentoringInvoice::where("code", $request->order_id)->first();
            if ($paymentMentoring) {
                if (!in_array($request->status_code, ["200", "201"])) {
                    throw new \Exception("Error, pay invoice");
                }

                $paymentMentoring->status = "Success";
                $paymentMentoring->save();

                // $checkoutMentor = MentoringCheckout::find($paymentMentoring->mentoring_checkout_id);
                // if (!$checkoutMentor) throw new \Exception("Error, mentor ini tidak pernah checkout sebelumnya");

                // $checkoutMentor->status = "Success";
                // $checkoutMentor->save();

                DB::commit();
                return redirect()->route("instructor.transaction.mentoring");
            }

            throw new \Exception("Error, invoice not found");
        } catch (\Exception $e) {
            DB::rollBack();
            return abort(403);
        }
    }

    public function payMentoring(Request $request) {
        try {
            DB::beginTransaction();

            $schedule = ScheduleMentoring::where("id", $request->mentoring_id)->first();
            if (!$schedule) {
                throw new \Exception("Error, schedule not found!");
            }

            $mentoringCheckout = new MentoringCheckout();
            $mentoringCheckout->user_id = Auth::user()->id;
            $mentoringCheckout->schedule_id = $schedule->id;
            $mentoringCheckout->amount = 59999;
            $mentoringCheckout->save();
            
            $mentoringInvoice = new MentoringInvoice();
            $mentoringInvoice->user_id = Auth::user()->id;
            $mentoringInvoice->mentoring_checkout_id = $mentoringCheckout->id;
            $mentoringInvoice->code = "EMTRG-". time() . rand(10, 998);
            $mentoringInvoice->name = Auth::user()->name;
            $mentoringInvoice->email = Auth::user()->email;
            $mentoringInvoice->amount = $mentoringCheckout->amount;
            $mentoringInvoice->note = "Pendaftaran Program Mentoring Edukasi 4.0 | ". Carbon::now();
            $mentoringInvoice->save();

            $payload = [
                "transaction_details" => [
                    "order_id"     => $mentoringInvoice->code,
                    "gross_amount" => $mentoringInvoice->amount,
                ],
                "customer_details" => [
                    "first_name" => $mentoringInvoice->name,
                    "email"      => $mentoringInvoice->email,
                ],
                "item_details" => [
                    [
                        "id"            => $mentoringInvoice->code,
                        "price"         => $mentoringInvoice->amount,
                        "quantity"      => 1,
                        "name"          => "Pendaftaran Program Mentoring Edukasi 4.0 | ". Carbon::now(),
                        "brand"         => "Edukasi",
                        "category"      => "Program Mentoring",
                        "merchant_name" => "Edukasi 4.0",
                    ],
                ],
            ];
            $snapToken = MidtransSnap::getSnapToken($payload);
            $snapUrl = MidtransSnap::getSnapUrl($payload);

            $mentoringInvoice->snap_token = $snapToken;
            $mentoringInvoice->snap_url = $snapUrl;
            $mentoringInvoice->save();

            DB::commit();
            return redirect()->route("instructor.transaction.mentoring");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function checkStatus(Request $request) {
        $mid = MidtransTransaction::status($request->code);
        var_dump($mid);
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.sandbox.midtrans.com/v2/'. $request->code .'/status',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'GET',
        //     CURLOPT_HTTPHEADER => array(
        //         'Authorization: basic '. base64_encode(env("MIDTRANS_SERVER_KEY") .":edukasiempatnol@gmail.com:". "D3w4n99@2023")
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // return response()->json(["data" => json_decode($response)]);
    }
}
