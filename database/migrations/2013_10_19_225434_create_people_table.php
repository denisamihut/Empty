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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            //NORMAL PEOPLE
            $table->string('name')->nullable();
            $table->string('dni')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('age')->nullable();
            $table->date('birthday')->nullable();
            // BUSINESS PEOPLE
            $table->string('social_reason')->nullable();
            $table->string('ruc')->nullable();
            $table->string('address')->nullable();

            $table->foreignId('district_id')->nullable()->references('id')->on('districts');
            $table->foreignId('province_id')->nullable()->references('id')->on('provinces');
            $table->foreignId('department_id')->nullable()->references('id')->on('departments');
            $table->foreignId('country_id')->nullable()->references('id')->on('countries');

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
        Schema::dropIfExists('people');
    }
};