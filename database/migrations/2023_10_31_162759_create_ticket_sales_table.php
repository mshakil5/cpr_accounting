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
        Schema::create('ticket_sales', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('number')->nullable();
            $table->double('price_per_unit',10,2)->nullable();
            $table->double('amount',10,2)->nullable();
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
        Schema::dropIfExists('ticket_sales');
    }
};
