<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectThink extends Model
{
    protected $table = 'project_think';
	
	protected $primaryKey = 'pt_id';

	protected $fillable = ['p_id', 'v_id', 'pt_content', 'pt_require', 'pt_check', 'pt_expect'];
}
