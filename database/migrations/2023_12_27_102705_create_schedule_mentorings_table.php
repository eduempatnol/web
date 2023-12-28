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
        Schema::create('schedule_mentorings', function (Blueprint $table) {
            $table->id();
            $table->enum("schedule_type", ["online", "offline"]);
            $table->timestamp("schedule_from")->nullable();
            $table->timestamp("schedule_to")->nullable();
            $table->string("schedule_link")->nullable();
            $table->string("schedule_address")->nullable();
            $table->enum("schedule_expired", ["active", "expired"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_mentorings');
    }
};
