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
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('number')->nullable();
            $table->foreignId('processtype_id')->nullable()->references('id')->on('processtypes');
            $table->string('status')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('amountreal', 10, 2)->nullable();
            $table->decimal('days', 10, 2)->nullable();
            $table->string('payment_type')->nullable();
            $table->foreignId('room_id')->nullable()->references('id')->on('rooms');
            $table->foreignId('client_id')->nullable()->references('id')->on('people');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('booking_id')->nullable()->references('id')->on('bookings');
            $table->foreignId('branch_id')->nullable()->references('id')->on('branches');
            $table->foreignId('business_id')->nullable()->references('id')->on('business');
            $table->foreignId('concept_id')->nullable()->references('id')->on('concepts');
            $table->foreignId('cashbox_id')->nullable()->references('id')->on('cashboxes');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processes');
    }
};