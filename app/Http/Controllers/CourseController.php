<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function courseDetail(Request $request, $slug) {
        $course = Course::with("user", "lessons")->where("course_slug", $slug)->first();
        if (!$course) {
            return abort(404);
        }

        return view("course-detail", compact("course"));
    }

    public function courseCheckout(Request $request, $slug) {
        $course = Course::with("user", "lessons")->where("course_slug", $slug)->first();
        if (!$course) {
            return abort(404);
        }

        return view("course-checkout", compact("course"));
    }
}
