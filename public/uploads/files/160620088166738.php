<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suggestion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'topic', 'suggestion', 'user_id', 'user_type', 'status', 'seen_at', 'seen_by','suggestion_type_id',"order_id"
    ];
    protected $hidden = ['user_id', 'user_type'];
    protected $appends = ['type'];

    public function user()
    {
        return $this->morphTo('user');
    }

    
    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function delegates()
    {
        return $this->belongsTo('App\Models\Delegate','user_id');
    }
    public function seen_admin()
    {
        return $this->belongsTo('App\Models\Admin','seen_by');
    }

    public function getTypeAttribute()
    {
        if ($this->user_type == 'App\Models\Delegate') {
            return 'delegate';
        } elseif ($this->user_type == 'App\Models\User') {
            return 'user';
        } else {
            return 'user';
        }
    }
}
