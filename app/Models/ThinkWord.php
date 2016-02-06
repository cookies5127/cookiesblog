<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThinkWord extends Model
{
    protected $table = 'think_word';

	protected $primaryKey = 'tw_id';

	protected $fillable = ['tw_word', 't_id', 'tw_content'];
}
