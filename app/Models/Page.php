<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model {
    //
    use SoftDeletes;

    protected $table = 'pages';
    protected $fillable = ['title', 'content', 'user_id'];

    function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
