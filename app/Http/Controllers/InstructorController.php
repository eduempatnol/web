<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseInvoice;
use App\Models\Ebook;
use App\Models\Lessons;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class InstructorController extends Controller
{
    public function dashboard() {
        return view("instructor.dashboard");
    }

    public function courses() {
        return view("instructor.courses");
    }

    public function courseAdd() {
        return view("instructor.course.add");
    }

    public function courseData(Request $request) {
        $data = Course::with("lessons")->where("user_id", Auth::user()->id)->get();
        return DataTables::of($data)->toJson();
    }

    public function courseSubmit(Request $request) {
        try {
            DB::beginTransaction();

            $course = new Course();

            if ($request->hasFile("course_thumbnail")) {
                $file = $request->file("course_thumbnail");
                $extension = $file->getClientOriginalExtension();
                $filenameSave = time() . "_" . rand(100, 9999) . "." . $extension;
                $file->move("uploads", $filenameSave);

                $course->course_thumbnail = "uploads/" . $filenameSave;
            }

            $course->user_id = Auth::user()->id;
            $course->course_title = $request->course_title;
            $course->course_tagline = $request->course_tagline;
            $course->course_description = $request->course_description;
            $course->course_price = implode("", explode(",", $request->course_price));
            $course->course_certificate = $request->course_certificate;
            $course->consultation_certificate = $request->consultation_certificate;
            $course->course_slug = Str::slug($request->course_title, "-");
            $course->save();

            if ($request->consultation_certificate == 1) {
                if (!$request->consultation_link || !$request->consultation_date || !$request->consultation_time) {
                    throw new \Exception("Error, link konsultasi dan waktu konsultasi harus di isi");
                }

                $course->consultation_link = $request->consultation_link;
                $course->consultation_date = $request->consultation_date ." ". $request->consultation_time;
                $course->save();
            }

            if ($request->lesson_title) {
                foreach ($request->lesson_title as $key => $lessonTitle) {
                    $lesson = new Lessons();
                    $lesson->course_id = $course->id;
                    $lesson->lesson_title = $lessonTitle;
                    $lesson->lesson_link = $request->lesson_link[$key];
                    $lesson->lesson_duration = $request->lesson_duration[$key];
                    $lesson->lesson_sorting = $key + 1;
                    $lesson->save();
                }
            }

            if ($request->ebook_title) {
                foreach ($request->ebook_title as $key => $ebookTitle) {
                    $ebook = new Ebook();
                    $ebook->course_id = $course->id;
                    $ebook->ebook_title = $ebookTitle;
                    $ebook->ebook_link = $request->ebook_link[$key];
                    $ebook->save();
                }
            }

            if ($request->question) {
                foreach ($request->question as $key => $question) {
                    $quiz = new Quiz();
                    $quiz->course_id = $course->id;
                    $quiz->question = $question;
                    $quiz->type = $request->type[$key];
                    $quiz->a = empty($request->a[$key]) ? null : $request->a[$key];
                    $quiz->b = empty($request->b[$key]) ? null : $request->b[$key];
                    $quiz->c = empty($request->c[$key]) ? null : $request->c[$key];
                    $quiz->d = empty($request->d[$key]) ? null : $request->d[$key];
                    $quiz->save();
                }
            }

            DB::commit();
            return redirect()->route("instructor.courses");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->withErrors(["message" => $e->getMessage()]);
        }
    }

    public function transaction() {
        return view("instructor.transaction");
    }

    public function getDataTransaction(Request $request) {
        $course = Course::where("user_id", Auth::user()->id)->pluck("id");
        $invoices = CourseInvoice::whereIn("course_id", $course)->select("code", "name", "amount", "note", "status")->get();

        return DataTables::of($invoices)->toJson();
    }
}
