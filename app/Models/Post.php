<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {
    //
    use SoftDeletes;
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(CategoryPost::class, 'category_post_id');
    }
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
