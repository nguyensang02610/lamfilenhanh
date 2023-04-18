<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable=['user_id','ma_hinh', 'dong_may ', 'note'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}