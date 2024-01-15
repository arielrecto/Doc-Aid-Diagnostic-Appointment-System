<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FamilyMember extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'image',
        'full_name',
        'last_name',
        'first_name',
        'middle_name',
        'birthdate',
        'sex',
        'contact_no',
        'email',
        'relationship',
        'valid_id_image',
        'valid_id_type',
        'valid_id_number',
        'family_id'
    ];


    public function family(){
        return $this->belongsTo(Family::class);
    }
}
