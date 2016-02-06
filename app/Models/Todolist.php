<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    protected $table = 'todolist';

	protected $primaryKey = 'td_id';

	protected $fillable = ['td_name', 'td_expect', 'td_result', 'td_type', 'td_sort', 'is_finish'];
}
