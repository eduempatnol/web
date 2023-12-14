<?php

namespace App\Http\Controllers;

use App\Models\CategoryMentoring;
use App\Models\Course;
use App\Models\CourseInvoice;
use App\Models\SalesFee;
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

    public function mentoringCategoryData(Request $request) {
        $category = CategoryMentoring::orderBy("id", "desc")->get();
        return DataTables::of($category)->toJson();
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
}
