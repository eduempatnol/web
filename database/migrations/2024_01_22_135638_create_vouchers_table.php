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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string("code_voucher")->unique();
            $table->enum("type_voucher", ["single", "package"]);
            $table->enum("benefit_voucher", ["discount", "course"]);
            $table->enum("based_voucher", ["time", "use"]);
            $table->timestamp("valid_voucher")->nullable();
            $table->timestamp("expired_voucher")->nullable();
            $table->string("used_voucher")->nullable();
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
        Schema::dropIfExists('vouchers');
    }
};
