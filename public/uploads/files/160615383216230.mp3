<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $table = 'cities';
    protected $fillable = [
        'governorate_id', 'name_ar', 'name_en'
    ];
    // protected $hidden = ['name_ar', 'name_en'];
    protected $appends = [
        'name','web_name'
    ];
    public function getNameAttribute()
    {
        if (request()->header('Accept-Language') == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }
    public function governorate()
    {
        return $this->belongsTo('App\Models\Governorate', 'governorate_id')->with('country');
    }

    public function getWebNameAttribute()
    {
        if (session()->has('lang') && session()->get('lang') == 'en') {
            return $this->name_en;
        }
        return $this->name_ar;
    }


}
