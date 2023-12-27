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
        Schema::create('restaurant_exp_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceno')->nullable();
            $table->bigInteger('restaurant_expense_id')->unsigned()->nullable();
            $table->foreign('restaurant_expense_id')->references('id')->on('restaurant_expenses')->onDelete('cascade');
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->string('productname')->nullable();
            $table->string('qty')->nullable();
            $table->double('price_per_unit',10,2)->default(0);
            $table->double('price',10,2)->default(0);
            $table->string('status')->default(1);
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
        Schema::dropIfExists('restaurant_exp_details');
    }
};
