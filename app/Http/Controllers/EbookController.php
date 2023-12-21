<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCheckout;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class EbookController extends Controller
{
    public function getEbook(Request $request, $slug, $ebookId) {
        $course = Course::with("ebooks", "invoices")->where("course_slug", $slug)->first();
        if (!$course) abort(403);

        $ebook = $course->ebooks->where("id", $ebookId)->first();
        if (!$ebook) abort(403);

        $invoice = $course->invoices->where("user_id", Auth::user()->id)->where("status", "Success")->first();
        if (!$invoice) abort(403);

        $url = $ebook->ebook_link;
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Host: ". parse_url($url)["host"] ."\r\n"
                    . "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:71.0) Gecko/20100101 Firefox/71.0\r\n"
                    . "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n"
                    . "Accept-Language: en-US,en;q=0.5\r\n"
                    . "Accept-Encoding: gzip, deflate, br\r\n",
            ],
            "https" => [
                "method" => "GET",
                "header" => "Host: ". parse_url($url)["host"] ."\r\n"
                    . "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:71.0) Gecko/20100101 Firefox/71.0\r\n"
                    . "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n"
                    . "Accept-Language: en-US,en;q=0.5\r\n"
                    . "Accept-Encoding: gzip, deflate, br\r\n",
            ],
        ];

        return Response::make(file_get_contents($url), 200, [
            "Content-Type" => "application/pdf",
            "Content-Disposition" => "inline; filename='document.pdf'; name='. $ebook->ebook_title .'",
            "Host" => parse_url($url)["host"],
            "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64; rv:71.0) Gecko/20100101 Firefox/71.0",
            "Cache-Control" => "no-cache",
            "Pragma" => "no-cache",
        ]);
    }
}
