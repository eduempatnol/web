<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index() {
        return view("forum");
    }

    public function courseForum(Request $request, $courseSlug) {
        $course = Course::with("forum.threads.comments", "forum.threads.user")->where("course_slug", $courseSlug)->first();
        if (!$course) return abort(404);
        if (!$course->forum) return abort(404);

        $forum = $course->forum;
        // dd($forum);
        return view("course-forum", compact("forum"));
    }
}
