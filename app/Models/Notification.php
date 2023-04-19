<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable=['user_id','create_file_id', 'content', 'zone'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}