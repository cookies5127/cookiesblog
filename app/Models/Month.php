<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = 'month';

	protected $primaryKey = 'm_id';

	protected $fillable = ['m_name', 'm_when', 'm_expect', 'm_result', 'm_cost'];
}
