<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //


	protected $guarded = [];



	public function parent(){
		return $this->belongsTo('App\Models\Message', 'parent_id');
	}
	public function role(){
		return $this->belongsTo('App\Models\Role');
	}
	public function expediteur(){
		return $this->belongsTo('App\User','sender_id');
	}
	public function destinaire(){
		return $this->belongsTo('App\User','receptor_id');
	}
}
