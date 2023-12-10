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
        Schema::create('wallet_logs', function (Blueprint $table) {
            $table->id();
            $table->string("from_table_wallet");
            $table->bigInteger("from_table_wallet_id");
            $table->string("from_table_invoice");
            $table->bigInteger("from_table_invoice_id");
            $table->double("invoice_amount");
            $table->string("cut_sales");
            $table->double("income");
            $table->double("wallet_balance_current");
            $table->double("wallet_balance");
            $table->text("remarks");
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
        Schema::dropIfExists('wallet_logs');
    }
};
