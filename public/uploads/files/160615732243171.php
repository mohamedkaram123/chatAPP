<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles;
    protected $guarded = 'admin';
    protected $table = 'admins';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'email', 'password', 'remember_token', 'department_id');
    protected $hidden = array('password', 'remember_token');

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }
}