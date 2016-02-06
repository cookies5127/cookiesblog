<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPlan extends Model
{
    protected $table = 'project_plan';

	protected $primaryKey = 'pp_id';

	protected $fillable = ['p_id', 'v_id', 'pp_when', 'pp_what', 'pp_cost', 'pp_fact_cost', 'pp_log'];

	public function scopePro($query, $id) 
	{
		return $query->where('p_id', $id[0])->where('v_id', $id[1])->first();
	}
}
