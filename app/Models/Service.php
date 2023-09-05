<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'init_payment',
        'time_slot',
        'session_time',
        'extension_time',
        'extension_price'
    ];


    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public static function total()
    {
        $total = Service::get()->count();
        return $total;
    }
    public static function totalBaseOnAvailability($availability)
    {

        $builder = Service::where(function($q) use($availability) {
            $q->where('availability', '=', $availability);
        });

        $total = $builder->count();

        return $total;
    }
}
