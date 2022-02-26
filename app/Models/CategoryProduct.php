<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProduct extends Model {
    //
    use SoftDeletes;
    protected $guarded = [];

    public function catProductChild() {
        return $this->hasMany(CategoryProduct::class, 'parent_id');
    }

    public function catProductParent() {
        return $this->belongsTo(CategoryProduct::class, 'parent_id');
    }
}
