<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, "home"])->name("welcome");

Route::get("login", [AuthController::class, "login"])->name("login");
Route::post("login", [AuthController::class, "loginPost"])->name("login.post");
Route::get("register", [AuthController::class, "register"])->name("register");
Route::post("register", [AuthController::class, "registerPost"])->name("register.post");
Route::post("logout", [AuthController::class, "logout"])->name("logout");

Route::group(["prefix" => "admin", "middleware" => ["is_admin"]], function() {
	Route::get("", [AdminController::class, "dashboard"])->name("admin.dashboard");
	Route::get("settings", [AdminController::class, "settings"])->name("admin.settings");
	Route::post("change/rate", [AdminController::class, "changeRate"])->name("admin.settings.rate");
	Route::group(["prefix" => "mentoring"], function() {
		Route::get("category", [AdminController::class, "mentoringCategory"])->name("mentoring.category");
		Route::post("category", [AdminController::class, "storeMentoringCategory"])->name("mentoring.category.store");
		Route::post("category/update", [AdminController::class, "updateMentoringCategory"])->name("mentoring.category.update");
		Route::get("category/data", [AdminController::class, "mentoringCategoryData"])->name("mentoring.category.data");
		Route::get("schedule", [AdminController::class, "mentoringSchedule"])->name("mentoring.schedule");
		Route::post("schedule", [AdminController::class, "storeMentoringSchedule"])->name("mentoring.schedule.store");
		Route::get("schedule/data", [AdminController::class, "mentoringScheduleData"])->name("mentoring.schedule.data");
	});
});

Route::group(["prefix" => "user", "middleware" => ["is_user"]], function() {
	Route::get("", [UserController::class, "dashboard"])->name("user.dashboard");
	Route::get("class", [UserController::class, "class"])->name("user.class");
	Route::get("class/{courseId}", [UserController::class, "getCourseUser"])->name("user.class.course");
});

Route::group(["prefix" => "instructor", "middleware" => ["is_instructor"]], function() {
	Route::get("", [InstructorController::class, "dashboard"])->name("instructor.dashboard");
	Route::get("courses", [InstructorController::class, "courses"])->name("instructor.courses");
	Route::get("courses/data", [InstructorController::class, "courseData"])->name("instructor.courses.data");
	Route::get("courses/add", [InstructorController::class, "courseAdd"])->name("instructor.course.add");
	Route::get("courses/edit/{id}", [InstructorController::class, "courseEdit"])->name("instructor.course.edit");
	Route::post("courses/submit", [InstructorController::class, "courseSubmit"])->name("instructor.course.submit");
	Route::put("courses/update/{id}", [InstructorController::class, "courseUpdate"])->name("instructor.course.update");
	Route::get("course/transaction", [InstructorController::class, "transaction"])->name("instructor.transaction");
	Route::get("course/transaction/data", [InstructorController::class, "getDataTransaction"])->name("instructor.transaction.data");
	// Route::post("mentoring/store", [InstructorController::class, "sotreInstuctorMentoring"])->name("instructor.mentoring.store");
});

Route::group(["prefix" => "course"], function() {
	Route::get("", [CourseController::class, "index"])->name("course.index");
	Route::get("checkout/{slug}", [CourseController::class, "courseCheckout"])->name("course.checkout");
	Route::get("{slug}", [CourseController::class, "courseDetail"])->name("course.detail");
});

Route::group(["prefix" => "payment", "middleware" => "auth"], function() {
	Route::post("course", [PaymentController::class, "payCourse"])->name("payment.course");
	Route::get("finish", [PaymentController::class, "finishPayment"])->name("payment.finish");
	Route::post("mentoring", [PaymentController::class, "payMentoring"])->name("payment.mentoring");
});

Route::group(["prefix" => "forum"], function() {
	Route::get("{courseSlug}", [ForumController::class, "courseForum"]);
});

Route::group(["prefix" => "ebook", "middleware" => ["auth"]], function() {
	Route::get("{slug}/{ebookId}", [EbookController::class, "getEbook"])->name("ebook.see");
});
