<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likeable';
    
 	protected $fillable = ['user_id'];

    public function likeable()
    {
        return $this->morphTo();
    }

 	public function user()
 	{
		return $this->belongsTo('App\models\User', 'user_id');
 	}
}
