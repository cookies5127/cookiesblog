<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frags extends Model
{
	use SoftDeletes;

	protected $table = 'fragments';

	protected $dates = ['deleted_at'];

	protected $fillable = ['content'];
}
