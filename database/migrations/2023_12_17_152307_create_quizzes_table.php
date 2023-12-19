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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("course_id");
            $table->string("question");
            $table->enum("type", ["choice", "essays"]);
            $table->string("A")->nullable();
            $table->string("B")->nullable();
            $table->string("C")->nullable();
            $table->string("D")->nullable();
            $table->string("answer")->nullable();
            $table->timestamps();

            $table->foreign("course_id")->references("id")->on("courses")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};
