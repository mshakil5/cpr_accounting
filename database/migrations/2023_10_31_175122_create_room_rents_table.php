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
        Schema::create('room_rents', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('v_name')->nullable();
            $table->string('v_number')->nullable();
            $table->string('v_address')->nullable();
            $table->string('v_nid')->nullable();
            $table->string('room_number')->nullable();
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
        Schema::dropIfExists('room_rents');
    }
};
