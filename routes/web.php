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
	Route::get("instructors", [AdminController::class, "instructors"])->name("admin.instructors");
	Route::get("instructors/data", [AdminController::class, "dataInstructors"])->name("admin.instructors.data");
	Route::get("instructors/up", [AdminController::class, "upInstructor"])->name("admin.instructors.up");
	Route::get("instructors/down", [AdminController::class, "downInstructor"])->name("admin.instructors.down");
});

Route::group(["prefix" => "user", "middleware" => ["is_user"]], function() {
	Route::get("", [UserController::class, "dashboard"])->name("user.dashboard");
	Route::get("class", [UserController::class, "class"])->name("user.class");
	Route::get("class/{courseId}", [UserController::class, "getCourseUser"])->name("user.class.course");
});

Route::group(["prefix" => "instructor", "middleware" => ["is_instructor"]], function() {
	Route::get("", [InstructorController::class, "dashboard"])->name("instructor.dashboard");
	Route::group(["prefix" => "courses"], function() {
		Route::get("", [InstructorController::class, "courses"])->name("instructor.courses");
		Route::get("data", [InstructorController::class, "courseData"])->name("instructor.courses.data");
		Route::get("add", [InstructorController::class, "courseAdd"])->name("instructor.course.add");
		Route::get("edit/{id}", [InstructorController::class, "courseEdit"])->name("instructor.course.edit");
		Route::post("submit", [InstructorController::class, "courseSubmit"])->name("instructor.course.submit");
		Route::put("update/{id}", [InstructorController::class, "courseUpdate"])->name("instructor.course.update");
		Route::get("transaction", [InstructorController::class, "transaction"])->name("instructor.transaction");
		Route::get("transaction/data", [InstructorController::class, "getDataTransaction"])->name("instructor.transaction.data");
		Route::get("{courseId}", [InstructorController::class, "userInCourse"])->name("instructor.users.course");
		Route::post("{courseId}", [InstructorController::class, "userInCourseData"])->name("instructor.users.course.data");
	});
	// Route::post("mentoring/store", [InstructorController::class, "sotreInstuctorMentoring"])->name("instructor.mentoring.store");
	Route::get("mentoring/transaction", [InstructorController::class, "transactionMentoring"])->name("instructor.transaction.mentoring");
	Route::get("mentoring/transaction/data", [InstructorController::class, "getDataTransactionMentoring"])->name("instructor.transaction.mentoring.data");

	// upload
	Route::post("courseupload", [InstructorController::class, "uploadCertificate"])->name("instructor.upload.certificate");
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
	Route::get("checkStatus/{code}", [PaymentController::class, "checkStatus"])->name("payment.status");
});

Route::group(["prefix" => "forum", "middleware" => ["auth"]], function() {
	Route::post("comment/{threadId}", [ForumController::class, "commentThread"])->name("comment.post");
	Route::post("threads/{forum_id}", [ForumController::class, "postThreads"])->name("threads.post");
	Route::get("{courseSlug}/{threadId}", [ForumController::class, "showThreads"])->name("threads.show");
	Route::get("{courseSlug}", [ForumController::class, "courseForum"]);
});

Route::group(["prefix" => "ebook", "middleware" => ["auth"]], function() {
	Route::get("{slug}/{ebookId}", [EbookController::class, "getEbook"])->name("ebook.see");
});
