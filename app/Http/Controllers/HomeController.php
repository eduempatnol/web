<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function home() {
        Log::alert("Home Load");
        $courses = Course::orderBy("course_watchlist", "desc")->limit(10)->get();
        return view("welcome", compact(("courses")));
    }
}
