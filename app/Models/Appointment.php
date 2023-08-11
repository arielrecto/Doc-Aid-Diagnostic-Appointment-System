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
        'is_approved'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function services(){
        return $this->belongsToMany(Service::class);
    }
}
