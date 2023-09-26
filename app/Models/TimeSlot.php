<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;
    protected $fillable = [
        'slots',
        'date',
        'service_id'
    ];
    public function service(){
        return $this->belongsTo(service::class);
    }
}
