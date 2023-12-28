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
        Schema::create('mentoring_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("mentoring_checkout_id");
            $table->string("code")->unique();
            $table->string("name");
            $table->string("email")->nullable();
            $table->double("amount")->default(0);
            $table->text("note")->nullable();
            $table->enum("status", ["Pending", "Success", "Expired", "Error"])->default("Pending");
            $table->string("snap_token")->nullable();
            $table->string("snap_url")->nullable();
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("mentoring_checkout_id")->references("id")->on("mentoring_checkouts")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentoring_invoices');
    }
};
