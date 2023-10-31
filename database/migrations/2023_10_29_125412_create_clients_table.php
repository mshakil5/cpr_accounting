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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_name')->nullable();
            $table->string('passport_image')->nullable();
            $table->string('visa')->nullable();
            $table->string('manpower_image')->nullable();
            $table->string('country')->nullable();
            $table->double('package_cost',10,2)->default(0);
            $table->string('passport_rcv_date')->nullable();
            $table->double('due_amount',10,2)->default(0);
            $table->double('total_rcv',10,2)->default(0);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
