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
            $table->string('time');
            $table->string('type');
            $table->foreignIdFor(Service::class);
            $table->boolean('is_approved')->default(false);
            $table->string('receipt_image');
            $table->foreignIdFor(User::class);
            $table->string('status');
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
