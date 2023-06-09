<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneReplace extends Model
{
    protected $fillable=['user_id','dong_may', 'dong_may_thay', 'note'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}