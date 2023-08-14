<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'init_payment'
    ];


    public function appointments (){
        return $this->hasMany(Appointment::class);
    }
    public static function total() {
        $total = Service::get()->count();
        return $total;
    }
}
