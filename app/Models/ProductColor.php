<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model {
    //
    use SoftDeletes;
    protected $guarded = [];

    public function color() {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
