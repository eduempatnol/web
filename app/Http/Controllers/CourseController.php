<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::query()->orderBy("id", "desc")->get();
        return view("course-index", compact("courses"));
    }

    public function courseDetail(Request $request, $slug) {
        $course = Course::with("user", "lessons")->where("course_slug", $slug)->first();
        $courseCheckout = null;

        if (Auth::check()) {
            $courseCheckout = CourseCheckout::where("user_id", Auth::user()->id)->where("course_id", $course->id)->first();
        }

        if (!$course) {
            return abort(404);
        }

        return view("course-detail", compact("course", "courseCheckout"));
    }

    public function courseCheckout(Request $request, $slug) {
        $course = Course::with("user", "lessons")->where("course_slug", $slug)->first();
        if (!$course) {
            return abort(404);
        }

        if (!Auth::check()) {
            return redirect()->route("login");
        }

        $courseCheckout = CourseCheckout::where("user_id", Auth::user()->id)->where("course_id", $course->id)->first();
        if ($courseCheckout) {
            return abort(404);
        }

        return view("course-checkout", compact("course"));
    }
}
