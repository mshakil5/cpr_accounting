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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->bigInteger('chart_of_account_id')->unsigned()->nullable();
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
            $table->bigInteger('employee_id')->unsigned()->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->bigInteger('ticket_sale_id')->unsigned()->nullable();
            $table->foreign('ticket_sale_id')->references('id')->on('ticket_sales')->onDelete('cascade');
            $table->bigInteger('room_rent_id')->unsigned()->nullable();
            $table->foreign('room_rent_id')->references('id')->on('room_rents')->onDelete('cascade');
            $table->string('table_type')->nullable();
            $table->string('tran_title')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('description')->nullable();
            $table->double('amount',10,2)->nullable();
            $table->string('asset_id')->nullable();
            $table->string('liability_id')->nullable();
            $table->string('expense_id')->nullable();
            $table->string('income_id')->nullable();
            $table->string('owner_equity_id')->nullable();
            $table->string('created_ip')->nullable();
            $table->string('updated_ip')->nullable();
            $table->boolean('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
