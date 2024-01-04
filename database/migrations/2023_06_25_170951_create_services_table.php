<?php

use App\Models\Appointment;
use App\Models\TimeSlot;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('price');
            $table->longText('description');
            $table->string('init_payment');
            $table->string('session_time');
            $table->string('availability')->default('ACTIVE');
            $table->string('extension_time')->nullable();
            $table->string('extension_price')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
