<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentReschedule extends Model
{
    use HasFactory;


    protected $fillable = [
        'remark',
        'appointment_id',
        'status',
        'date',
        'start_time',
        'end_time'
    ];


    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }
}
