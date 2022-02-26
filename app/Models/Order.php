<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
    //
    use SoftDeletes;
    public $incrementing = false;
    protected $guarded = [];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
