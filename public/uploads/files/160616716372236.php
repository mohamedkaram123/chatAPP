<?php

namespace App\Models;

use App\Models\RelationCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{

    protected $table = 'companies';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', 'address', 'phone', 'fax', 'email', 'website', 'facebook', 'mobile_1', 'mobile_2',
        'commercial_number', 'commercial_image', 'tax_card_number', 'tax_card_front_image', 'tax_card_back_image', 'logo',
        'max_weight', 'additional_weight_price', 'package_id','owner_name', 'status',"commission_id","payment_method","return_percentage"
    ];
       

    protected $appends = [
        'rate_company'
    ];

    public function getStatusText() {
        if ($this->status ==  "active")
            return "مفعل";
        else if ($this->status ==  "not_active")
            return "غير مفعل";
        else if ($this->status ==  "frozen")
            return "مجمد";
        else
            return "";
    }

    public function employees()
    {
        return $this->hasMany('App\Models\Employee', 'company_id');
    }

    public function delegates()
    {
        return $this->hasMany('App\Models\Delegate', 'company_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Package', 'package_id');
    }
    public function categories()
    {
        return $this->hasMany('App\Models\CompanyCategory', 'company_id');
    }


    public function companies()
    {
        return $this->hasMany('App\Models\RelationCompany', 'company_id1');
    }

    public function commission()
    {
        return $this->belongsTo('App\Models\Commission', 'commission_id');
    }


    public function getRateCompanyAttribute()
    {
//        return RateCompanies::where("id",$this->id)->get()->count();

        if(RateCompanies::where("id",$this->id)->get()->count() > 0){
            return RateCompanies::where("id",$this->id)->get()->first()->calc_rate_per;
        }else{
            return 0;
        }
    }
}