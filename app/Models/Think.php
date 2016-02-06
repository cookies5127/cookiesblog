<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Think extends Model
{
    protected $table = 'think';

	protected $primaryKey = 't_id';

	protected $fillable = ['title', 'body'];
}
