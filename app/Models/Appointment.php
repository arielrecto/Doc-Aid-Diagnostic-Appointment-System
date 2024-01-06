<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient',
        'date',
        'user_id',
        'type',
        'receipt_number',
        'receipt_image',
        'receipt_amount',
        'payment_type',
        'balance',
        'total',
        'status',
        'is_family',
        'family_member_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function subscribeServices(){
        return $this->hasMany(SubscribeService::class);
    }
    public function results(){
        return $this->hasMany(Result::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }
    public function today(){
        $appointments  = Appointment::with('subscribeServices.service')->where('date',now('GMT+8')->format('Y-m-d'))->get();
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
    public function currentMonth(){
        return Appointment::whereBetween('date', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')])->get();
    }
    public function total() {
        $total = $this->get()->count();

        return $total;
    }
    public function totalSaleInYear(string $year){
        $total = $this->whereStatus(AppointmentStatus::DONE->value)
        ->whereYear('created_at', $year)
        ->sum('total');
        return $total;
    }
}
