<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
	use SoftDeletes;

	protected $table = 'comments';

	protected $fillable = ['post_id','author','author_email','content'];

	protected $dates = ['deleted_at'];
}
