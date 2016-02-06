<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectBug extends Model
{
    protected $table = 'project_bug';

	protected $primaryKey = 'pb_id';

	protected $fillable = ['p_id', 'v_id', 'pb_bug', 'is_finish'];

	public function scopePro($query, $id) 
	{
		return $query->where('p_id', $id[0])->where('v_id', $id[1])->first();
	}
}
