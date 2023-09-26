<?php

use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patient');
            $table->string('date');
            $table->string('type');
            $table->string('receipt_image');
            $table->foreignIdFor(User::class);
            $table->string('status');
            $table->string('receipt_number')->nullable();
            $table->string('receipt_amount');
            $table->string('balance');
            $table->string('total');
            $table->boolean('is_extended')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
