<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metas extends Model
{
    //
	protected $table = 'metas';

	public $timestamps = false;

	public function scopeSidebar($query)
	{
		return $query->get();
	}

	public function content()
	{
		return $this->hasOne('App\Models\Posts','category_id','id');
	}
}
