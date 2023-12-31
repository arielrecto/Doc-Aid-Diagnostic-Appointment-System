<?php

namespace App\Models;

// use App\Http\Controllers\Admin\Availability;

use App\Enums\Availability;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
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
        'session_time',
        'extension_time',
        'extension_price',
        'availability'
    ];

    protected $casts = [
        'availability' => Availability::class
    ];

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
    public function subscribeServices()
    {
        return $this->hasMany(SubscribeService::class);
    }
    public static function total()
    {
        $total = Service::get()->count();
        return $total;
    }
    public static function totalBaseOnAvailability($availability)
    {

        $builder = Service::where(function ($q) use ($availability) {
            $q->where('availability', '=', $availability);
        });

        $total = $builder->count();

        return $total;
    }

    public function isAvailable(Availability|string|null $availability = null): EloquentCollection
    {
        $availability = $availability->name ?? $availability->value ?? $availability;

        return $this->whereAvailability($availability ?? $this->availability ?? 'ACTIVE')->get();
    }
    public function timeSlot(){
        return $this->hasMany(TimeSlot::class);
    }
    public function days(){
        return $this->belongsToMany(Day::class);
    }
}
