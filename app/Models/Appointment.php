<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient',
        'date',
        'user_id',
        'time',
        'type',
        'receipt_image',
        'receipt_amount',
        'balance',
        'total',
        'service_id',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function result(){
        return $this->hasMany(Result::class);
    }
    public static function today(){
        $appointments  = Appointment::with('service')->where('date',now('GMT+8')->format('Y-m-d'))->get();
        return $appointments;
    }
    public static function pending(){
        $appointments = Appointment::where('status', 'pending')->get();
        return $appointments;
    }
    public static function filter($data){
        if($data === 'today') {
            return $appointments = Appointment::where('date', now('GMT+8')->format('Y-m-d'))->get();
        }
        $appointments = Appointment::where('status', $data)->get();


        return $appointments;
    }
    public static function total() {
        $total = Appointment::count();

        return $total;
    }
}
