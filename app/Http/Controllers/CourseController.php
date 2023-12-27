<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCheckout;
use App\Models\Lessons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request) {
        $inputSearch = $request->q;
        $courses = Course::query()->orderBy("id", "desc")->where("course_title", "like", "%". $inputSearch ."%")->get();

        return view("course-index", compact("courses", "inputSearch"));
    }

    public function courseDetail(Request $request, $slug) {
        $course = Course::with([
            "user" => function($query) {
                $query;
            },
            "lessons" => function($query) {
                $query->take(4);
            },
            "ebooks" => function($query) {
                $query;
            }
        ])->where("course_slug", $slug)->first();

        $courseCheckout = null;
        $countLessons = Lessons::where("course_id", $course->id)->count();

        if (Auth::check()) {
            $courseCheckout = CourseCheckout::where("user_id", Auth::user()->id)->where("course_id", $course->id)->first();
        }

        if (!$course) {
            return abort(404);
        }

        return view("course-detail", compact("course", "courseCheckout", "countLessons"));
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
