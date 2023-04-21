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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('number');
            $table->string('type'); // T: Ticket, F: Factura, B: Boleta, R: Recibo, N: Nota de crédito, D: Nota de débito
            $table->string('status'); // P: Pendiente, C: Cancelado, A: Anulado
            $table->text('motivo_anulacion')->nullable(); // Nota de Creditos
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('igv', 10, 2)->nullable();
            $table->string('notes')->nullable();
            $table->foreignId('client_id')->nullable()->references('id')->on('people');
            $table->foreignId('process_id')->nullable()->references('id')->on('processes');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('branch_id')->nullable()->references('id')->on('branches');
            $table->foreignId('business_id')->nullable()->references('id')->on('business');
            $table->foreignId('billing_id')->nullable()->references('id')->on('billings'); // Nota de Creditos
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
        Schema::dropIfExists('billings');
    }
};