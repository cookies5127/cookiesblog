<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectWord extends Model
{
    protected $table = 'project_word';

	protected $primaryKey = 'pw_id';
	
	protected $fillable = ['p_id', 'v_id', 'pw_word', 'pw_content'];

	public function scopePro($query, $id) 
	{
		return $query->where('p_id', $id[0])->where('v_id', $id[1]);
	}
}
