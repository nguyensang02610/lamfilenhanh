<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infos extends Model
{
    protected $fillable=['user_id','lansudung', 'sourcefolder ', 'exportfolder' , 'exportname'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}