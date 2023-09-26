<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'path',
        'description',
        'appointment_id'
    ];

    public function appointment (){
        return $this->belongsTo(Appointment::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
