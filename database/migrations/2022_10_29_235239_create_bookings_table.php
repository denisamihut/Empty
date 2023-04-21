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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('datefrom');
            $table->date('dateto');
            $table->string('number')->nullable();
            $table->string('status')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('days', 10, 2)->nullable();
            $table->string('notes')->nullable();
            $table->foreignId('client_id')->nullable()->references('id')->on('people');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('room_id')->nullable()->references('id')->on('rooms');
            $table->foreignId('branch_id')->nullable()->references('id')->on('branches');
            $table->foreignId('business_id')->nullable()->references('id')->on('business');
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
        Schema::dropIfExists('bookings');
    }
};