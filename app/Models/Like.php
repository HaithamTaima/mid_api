<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','tweet_id'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class,'user_like','like_id','user_id');
    }
}
