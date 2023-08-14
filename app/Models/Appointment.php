<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'time',
        'type',
        'is_approved',
        'receipt_image',
        'service_id',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public static function today(){
        $appointments  = Appointment::with('service')->where('date',now('GMT+8')->format('Y-m-d'))->get();
        return $appointments;
    }
}
