<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input, DB, Redirect;

use App\Models\Posts;

class PostController extends Controller
{

	public function __construct()
	{
		//$this->middleware('auth',['except' => 'show']);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$list = Posts::orderBy('created_at', 'desc')->cates()->get();

		return response()->json($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$list = Posts::onlyTrashed()->cates()->get();

		return response()->json($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$id = Input::get('data.id');
		$data = $this->getInput();

		if ($id) {
			$post = Posts::withTrashed()->find($id)->update($data);
		} else {
			$post = Posts::firstOrCreate($data);
		}

		return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$page = Posts::withTrashed()->cates()->find($id);

		return response()->json($page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$posts = Posts::where('category_id', $id)->cates()->get();

		return response()->json($posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$post = Posts::withTrashed()->find($id)->restore();

		return $this->create();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$page = Posts::find($id);

		if ($page) {
			$page = $page->delete();
		} else {
			$page = Posts::withTrashed()->find($id)->forceDelete();
		}

		return response()->json($page);
    }

	public function getInput()
	{
		return [
			'title'			=> Input::get('data.title'),
			'summary'		=> Input::get('data.summary'),
			'category_id'	=> Input::get('data.category_id'),
			'body'			=> Input::get('data.body'),
		];
	}
}
