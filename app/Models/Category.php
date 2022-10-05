<?php

namespace App\Models;

use APP\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transitions(){
        return $this->hasMany(\App\Models\Transition::class);
    }
}
