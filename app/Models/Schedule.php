<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';

	protected $primaryKey = 's_id';

	protected $fillable = ['s_name', 's_slug', 's_type', 's_minute', 's_cost', 's_update'];

	public function scopeSlug($query, $type)
	{
		$date = date('Y-m-d');

		$info = $query->where('s_slug', $type)->where('created_at', 'like', '%'.$date.'%')->get();

		if (count($info)) {
			$r[0] = $info->sum('s_minute');
		} else {
			$r = [0];
		}

		return $r;
	}

	public function scopeTotal($query, $type)
	{
		$date = date('Y-m-d');

		return $query->where('s_slug', $type)->where('created_at', 'like', '%'.$date.'%')->first()->created_at;
	}
}
