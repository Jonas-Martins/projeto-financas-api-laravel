<?php

namespace App\Models;

use APP\Models\User;
use APP\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Transition extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'amount',
        'description',
        'user_id',
        'category_id',
        'finish'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
