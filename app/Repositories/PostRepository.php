<?php

namespace App\Repositories;

class PostRepository extends AbstractRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = new \App\Models\Posts;
	}

	public function find($id)
	{
		return $this->model->where('id',$id)->first();
	}

	public function create($data)
	{
		$page = $this->model->firstOrCreate($data);
		return $page;
	}
}
