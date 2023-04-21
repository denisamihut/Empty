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
        Schema::create('paymentprocesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_id')->nullable()->references('id')->on('processes');
            $table->foreignId('payment_id')->nullable()->references('id')->on('payments');
            $table->decimal('amount', 10, 2);
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
        Schema::dropIfExists('paymentprocesses');
    }
};