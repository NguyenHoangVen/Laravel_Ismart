<?php

namespace App;

use App\Models\Permission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use App\Page;

class User extends Authenticatable {
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function pages() {
        return $this->hasMany('App\Models\Page', 'user_id', 'id');
    }

    function role() {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function hasPermission(Permission $permission) {
        return !!optional(optional($this->role)->permissions)->contains($permission);
    }
}
