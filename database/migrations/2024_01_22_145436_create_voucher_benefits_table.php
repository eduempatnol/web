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
        Schema::create('voucher_benefits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("voucher_id");
            $table->string("type_benefit");
            $table->string("type_discount")->nullable();
            $table->string("type_course")->nullable();
            $table->timestamps();

            $table->foreign("voucher_id")->references("id")->on("vouchers")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_benefits');
    }
};
