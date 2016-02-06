<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $primaryKey = 'b_id';
	
	protected $table = 'book';

	protected $fillable = ['author', 'now', 'name', 'description'];
}
