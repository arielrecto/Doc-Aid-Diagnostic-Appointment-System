<?php

use App\Models\User;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
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
        Schema::create('appointment_reschedules', function (Blueprint $table) {
            $table->id();
            $table->longText('remark');
            $table->foreignIdFor(Appointment::class);
            $table->string('status')->default(AppointmentStatus::PENDING->value);
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_reschedules');
    }
};
