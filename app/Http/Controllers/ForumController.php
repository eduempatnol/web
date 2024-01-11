<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Forum;
use App\Models\ThreadComment;
use App\Models\Threads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    public function index() {
        return view("forum");
    }

    public function courseForum(Request $request, $courseSlug) {
        $course = Course::with([
            "forum.threads.comments" => function($query) {
                return $query;
            },
            "forum.threads.user" => function($query) {
                return $query;
            }
        ])->where("course_slug", $courseSlug)->first();
        if (!$course) return abort(404);
        if (!$course->forum) return abort(404);

        $forum = $course->forum;

        return view("course-forum", compact("forum"));
    }

    public function postThreads(Request $request, $forumId) {
        try {
            DB::beginTransaction();

            $forum = Forum::find($forumId);
            if (!$forum) throw new \Exception("Error, forum not found");

            $thread = new Threads();
            $thread->forum_id = $forum->id;
            $thread->user_id = Auth::user()->id;
            $thread->thread_title = $request->thread_title;
            $thread->thread_description = $request->thread_description;
            $thread->save();

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function showThreads(Request $request, $courseSlug, $threadId) {
        $course = Course::where("course_slug", $courseSlug)->first();
        if (!$course) return abort(404);

        $thread = Threads::with("comments.user")->where("id", $threadId)->first();
        if (!$thread) return abort(404);

        return view("forum-threads", compact("thread"));
    }

    public function commentThread(Request $request, $threadId) {
        try {
            DB::beginTransaction();

            $thread = Threads::find($threadId);
            if (!$thread) throw new \Exception("Error, thread not found!");

            $threadComment = new ThreadComment();
            $threadComment->thread_id = $thread->id;
            $threadComment->user_id = Auth::user()->id;
            $threadComment->comment = $request->comment;
            $threadComment->save();

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
}
