<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'full_name',
        'first_name',
        'last_name',
        'middle_name',
        'birthdate',
        'age',
        'gender',
        'contact_no',
        'street',
        'barangay',
        'municipality',
        'region',
        'zip_code',
        'user_id',
        'valid_id_image',
        'valid_id_type',
        'valid_id_number'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
