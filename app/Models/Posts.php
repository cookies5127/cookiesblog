<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class Posts extends Model
{
  	use SoftDeletes;

	protected $table = 'posts';

	protected static $index = ['id','slug'];

	protected $fillable = ['title','summary','body','category_id'];

	protected $dates = ['deleted_at'];

	public function scopeCates($query)
	{
		return $query->join('metas', 'metas.m_id', '=', 'posts.category_id')
					 ->select('metas.name', 'posts.title', 'posts.summary', 'posts.created_at', 'posts.id', 'posts.category_id', 'posts.body')
		;
	}

	public function scopeIndex()
	{
		$article = DB::table('posts')
						->join('metas','posts.category_id','=','metas.m_id')
						->orderBy('posts.created_at','desc')
						->select('metas.m_id as mid','metas.name','posts.id as tid','posts.title','posts.summary','posts.created_at as time','posts.updated_at as update')
						->simplePaginate(4);
		return $article;
	}

}
