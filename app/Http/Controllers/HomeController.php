<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {
        $courses = Course::orderBy("course_watchlist", "desc")->limit(10)->get();
        return view("welcome", compact(("courses")));
    }
}
