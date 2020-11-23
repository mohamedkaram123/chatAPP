<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Department extends Model
{
    use SoftDeletes;
    protected $table = 'departments';
    protected $fillable = [
        'name_ar', 'name_en'
    ];

    protected $hidden = ['name_ar', 'name_en'];
    protected $appends = [
        'name'
    ];
    public function getNameAttribute()
    {
        if (request()->header('Accept-Language') == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }
}
