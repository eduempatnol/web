<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseInvoice;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $courses = Course::count();
        $students = User::where("role_id", 2)->count();
        $instructors = User::where("role_id", 3)->count();
        $transaction = CourseInvoice::where("status", "Success")->sum("amount");
        return view("admin.dashboard", compact("courses", "students", "instructors", "transaction"));
    }
}
