<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCheck extends Model
{
    protected $table = 'project_check';

	protected $primaryKey = 'pc_id';

	protected $fillable = ['p_id', 'v_id', 'pc_question', 'pc_answer'];

	public function scopePro($query, $id) 
	{
		return $query->where('p_id', $id[0])->where('v_id', $id[1])->first();
	}
}
