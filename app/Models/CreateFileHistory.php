<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateFileHistory extends Model
{
    protected $fillable=['user_id','tong_don','tong_so_op','thanh_cong', 'that_bai '];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification', 'create_file_id');
    }
}