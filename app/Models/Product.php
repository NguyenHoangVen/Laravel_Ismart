<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    //
    use SoftDeletes;
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(CategoryProduct::class, 'category_product_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function colors() {
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id', 'color_id')
            ->withTimestamps();
    }
}
