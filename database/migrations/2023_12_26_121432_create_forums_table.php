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
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("course_id");
            $table->unsignedBigInteger("forum_admin");
            $table->string("forum_title");
            $table->text("forum_description")->nullable();
            $table->timestamps();

            $table->foreign("course_id")->references("id")->on("courses")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("forum_admin")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forums');
    }
};
