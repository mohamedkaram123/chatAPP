<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = [
        'name_ar','name_en','image', 'active','arrange_count'
    ];
    protected $hidden=['name_ar','name_en','arrange_count'];
    protected $appends=['name'];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getNameAttribute()
    {
        if (request()->header('Accept-Language') == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

}