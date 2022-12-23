<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'body',
    ];

    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id');
    }

    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');
    }
    
    public function replies()
    {
        return $this->hasMany('App\models\Status', 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany('App\models\Like', 'likeable');
    }
}

