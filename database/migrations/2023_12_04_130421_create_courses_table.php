<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("course_thumbnail")->nullable();
            $table->string("course_title");
            $table->string("course_tagline")->nullable();
            $table->text("course_description")->nullable();
            $table->double("course_price")->default(0);
            $table->boolean("course_certificate")->default(0);
            $table->boolean("consultation_certificate")->default(0);
            $table->boolean("course_is_active")->default(1);
            $table->bigInteger("course_watchlist")->default(0);
            $table->string("course_slug")->unique();
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
