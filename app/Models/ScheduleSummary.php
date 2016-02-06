<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleSummary extends Model
{
    protected $table = 'schedule_summary';

	protected $primaryKey = 'ss_id';

	protected $fillable = ['ss_content', 'ss_score', 'ss_work', 'ss_exercise', 'ss_learning', 'ss_waste', 'ss_getup', 'ss_finish'];
}
