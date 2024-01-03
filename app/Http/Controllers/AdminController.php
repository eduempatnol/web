<?php

namespace App\Http\Controllers;

use App\Models\CategoryMentoring;
use App\Models\Course;
use App\Models\CourseInvoice;
use App\Models\MentoringCheckout;
use App\Models\MentoringInvoice;
use App\Models\SalesFee;
use App\Models\ScheduleMentoring;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard() {
        $courses = Course::count();
        $students = User::where("role_id", 2)->count();
        $instructors = User::where("role_id", 3)->count();
        $transaction = CourseInvoice::where("status", "Success")->sum("amount");
        return view("admin.dashboard", compact("courses", "students", "instructors", "transaction"));
    }

    public function settings() {
        $salesFee = SalesFee::first();
        return view("admin.settings", compact("salesFee"));
    }

    public function changeRate(Request $request) {
        try {
            DB::beginTransaction();

            $rate = SalesFee::where("id", 1)->first();
            $rate->type = $request->type;
            $rate->value = $request->value;
            $rate->save();

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function mentoringCategory() {
        return view("admin.mentoring.category");
    }

    public function mentoringSchedule() {
        return view("admin.mentoring.schedule");
    }

    public function mentoringCategoryData(Request $request) {
        $category = CategoryMentoring::query()->orderBy("id", "desc")->get();
        return DataTables::of($category)->toJson();
    }

    public function mentoringScheduleData(Request $request) {
        $schedule = ScheduleMentoring::query()->orderBy("id", "desc")->get();
        return DataTables::of($schedule)->toJson();
    }

    public function storeMentoringCategory(Request $request) {
        try {
            DB::beginTransaction();

            $category = new CategoryMentoring();
            $category->category_name = $request->name;
            $category->category_slug = Str::slug($request->name, "-");
            $category->save();

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function storeMentoringSchedule(Request $request) {
        try {
            DB::beginTransaction();

            $schedule = new ScheduleMentoring();
            $schedule->schedule_type = $request->category;
            $schedule->schedule_from = $request->start_date ." ". $request->start_time;
            $schedule->schedule_to = $request->end_date ." ". $request->end_time;

            if ($request->category == "online") {
                $schedule->schedule_link = $request->link;
            } elseif ($request->category == "offline") {
                $schedule->schedule_address = $request->address;
            } else {
                throw new \Exception("Error, type not found!");
            }

            $schedule->schedule_expired = "active";
            $schedule->save();

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function updateMentoringCategory(Request $request) {
        try {
            DB::beginTransaction();

            $category = CategoryMentoring::where("id", $request->id)->first();
            if (!$category) throw new \Exception("Error, Category not found");

            $category->category_name = $request->name;
            $category->category_slug = Str::slug($request->name, "-");
            $category->save();

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function instructors() {
        return view("admin.instructor.index");
    }

    public function dataInstructors(Request $request) {
        $instructors = MentoringCheckout::query()->with("user")->orderBy("id", "desc")->get();
        return DataTables::of($instructors)->toJson();
    }

    public function upInstructor(Request $request) {
        try {
            DB::beginTransaction();

            $ix = MentoringCheckout::where("id", $request->id)->first();
            if (!$ix) throw new \Exception("Error, data not found");

            $in = MentoringInvoice::where("mentoring_checkout_id", $ix->id)->where("status", "Success")->first();
            if (!$in) throw new \Exception("Belum melunasi pembayaran program mentoring");

            $ix->status = "Success";
            $ix->save();

            DB::beginTransaction();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::beginTransaction();
            return redirect()->back()->with("errors", $e->getMessage());
        }
    }

    public function downInstructor(Request $request) {
        try {
            DB::beginTransaction();

            $ix = MentoringCheckout::where("id", $request->id)->first();
            if (!$ix) throw new \Exception("Error, data not found");

            $in = MentoringInvoice::where("mentoring_checkout_id", $ix->id)->where("status", "Success")->first();
            if (!$in) throw new \Exception("Belum melunasi pembayaran program mentoring");

            $ix->status = "Expired";
            $ix->save();

            DB::beginTransaction();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::beginTransaction();
            return redirect()->back()->with("errors", $e->getMessage());
        }
    }
}
