<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infos extends Model
{
    protected $fillable = ['user_id', 'lansudung', 'sourcefolder ', 'exportfolder', 'exportname', 'lazada_dongmay', 'lazada_mahinh'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}