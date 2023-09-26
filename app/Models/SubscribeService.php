<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribeService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'appointment_id',
        'start_time',
        'end_time'
    ];


    public function service () {
        return $this->belongsTo(Service::class);
    }
    public function appointment() {
        return $this->belongsTo(Appointment::class);
    }
}
