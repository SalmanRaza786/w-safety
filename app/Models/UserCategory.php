<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;
    protected $fillable=['user_id','cat_id','is_subscribed'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }
}
