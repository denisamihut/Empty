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
        Schema::create('billingdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_id')->nullable()->references('id')->on('processes');
            $table->foreignId('billing_id')->nullable()->references('id')->on('billings');
            $table->foreignId('product_id')->nullable()->references('id')->on('products');
            $table->foreignId('service_id')->nullable()->references('id')->on('services');
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('branch_id')->nullable()->references('id')->on('branches');
            $table->foreignId('business_id')->nullable()->references('id')->on('business');
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
        Schema::dropIfExists('billingdetails');
    }
};