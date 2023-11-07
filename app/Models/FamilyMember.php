<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'full_name',
        'last_name',
        'first_name',
        'middle_name',
        'sex',
        'contact_no',
        'email',
        'relationship',
        'family_id'
    ];


    public function family(){
        return $this->belongsTo(Family::class);
    }
}
