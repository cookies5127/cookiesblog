<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
	
	protected $primaryKey = 'p_id';

	protected $fillable = ['v_id', 'p_name', 'p_status', 'p_summary', 'p_description', 'p_deadline', 'p_result'];
}
