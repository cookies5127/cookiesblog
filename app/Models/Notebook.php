<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    protected $table = 'notebook';

	protected $primaryKey = 'n_id';

	protected $fillable = ['title', 'c_id', 'body'];
}
