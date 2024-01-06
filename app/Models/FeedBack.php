<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    use HasFactory;


    protected $fillable = [
        'rate',
        'message',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
