<?php

namespace App\Repositories;

class PageRepository extends AbstractRepository
{

	protected $model;

	public function __construct()
	{
		$this->model = new \App\Models\Pages;
	}

	public function validate($value,$key)
	{
		return (is_array($value) && !empty($key));
	}

	public function create($value)
	{
		$model = $this->model;
		return $model::firstOrCreate($value);
	}

	public function find($v,$column = ['*'])
	{
		$model = $this->model;
		return $model::where('id',$v)->first($column);
	}

	public function deleted($id)
	{
		$model = $this->model;
		return $model::where('id',$id)->softDeletes();
	}

}
