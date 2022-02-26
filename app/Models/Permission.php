<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    //
    protected $guarded = [];
    public function groupPermission() {
        return $this->belongsTo(GroupPermission::class);
    }
}
