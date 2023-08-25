<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function members(){
        return $this->hasMany(FamilyMember::class);
    }
    public static function authUserFamilyMember(){

        if(Auth::user()->family === null){
            return [];
        }

        $members = Auth::user()->family->members()->get();
        return $members;
    }
}
