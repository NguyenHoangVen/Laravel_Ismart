<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model {
    //
    use SoftDeletes;
    protected $guarded = [];

    function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
