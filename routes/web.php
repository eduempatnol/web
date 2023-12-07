<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Route::get("login", [AuthController::class, "login"])->name("login");
Route::post("login", [AuthController::class, "loginPost"])->name("login.post");
Route::get("register", [AuthController::class, "register"])->name("register");
Route::post("logout", [AuthController::class, "logout"])->name("logout");

Route::group(["prefix" => "admin", "middleware" => ["is_admin"]], function() {
	Route::get("", [AdminController::class, "dashboard"])->name("admin.dashboard");
});

Route::group(["prefix" => "user", "middleware" => ["is_user"]], function() {
	Route::get("", [UserController::class, "dashboard"])->name("user.dashboard");
});

Route::group(["prefix" => "instructor", "middleware" => ["is_instructor"]], function() {
	Route::get("", [InstructorController::class, "dashboard"])->name("instructor.dashboard");
	Route::get("courses", [InstructorController::class, "courses"])->name("instructor.courses");
	Route::get("courses/data", [InstructorController::class, "courseData"])->name("instructor.courses.data");
	Route::get("courses/add", [InstructorController::class, "courseAdd"])->name("instructor.course.add");
	Route::post("courses/submit", [InstructorController::class, "courseSubmit"])->name("instructor.course.submit");
});

Route::group(["prefix" => "course"], function() {
	Route::get("checkout/{slug}", [CourseController::class, "courseCheckout"])->name("course.checkout");
	Route::get("{slug}", [CourseController::class, "courseDetail"])->name("course.detail");
});

Route::group(["prefix" => "payment", "middleware" => "auth"], function() {
	Route::post("course", [PaymentController::class, "payCourse"])->name("payment.course");
});