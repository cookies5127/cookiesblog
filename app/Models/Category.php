<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

	protected $primaryKey = 'c_id';

	protected $fillable = ['p_id', 'c_slug', 'c_name', 'c_description', 'location'];

	public $timestamps = false;
}
