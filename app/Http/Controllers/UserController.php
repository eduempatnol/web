<?php

namespace App\Http\Controllers;

use App\Models\CourseCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard() {
        return view("user.dashboard");
    }

    public function class() {
        $courseCheckout = CourseCheckout::with("course.lessons", "course.ebooks", "course.quis")->where("user_id", Auth::user()->id)->get();
        return view("user.class", compact("courseCheckout"));
    }

    public function getCourseUser(Request $request, $courseId) {
        try {
            $courseCheckout = CourseCheckout::with("course.lessons")->where("id", $courseId)->first();
            return response()->json(["status" => 200, "data" => $courseCheckout]);
        } catch (\Exception $e) {
            return response()->json(["status" => 400, "message" => $e->getMessage()], 400);
        }
    }
}
