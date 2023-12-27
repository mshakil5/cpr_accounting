<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurant_expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->string('invoiceno')->nullable();
            $table->string('date')->nullable();
            $table->string('description')->nullable();
            $table->double('vat_amount',10,2)->nullable();
            $table->double('discount',10,2)->nullable();
            $table->double('due_amount',10,2)->nullable();
            $table->double('paid_amount',10,2)->nullable();
            $table->double('net_amount',10,2)->nullable();
            $table->boolean('status')->default(1);
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_expenses');
    }
};
