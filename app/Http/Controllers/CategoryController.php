<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Models\Category;
use App\Models\Notebook;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::get();

		return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::where('location', '<>', 'seminar')->get();

		return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Input::get('data.c_id');
		$data = $this->getInput();

		if ($id) {
			$r = Category::find($id)->update($data);
		} else {
			$r = Category::firstOrCreate($data);
		}

		return response()->json($r);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
		$l = Input::get('data');
        $data['lists'] = Category::where('p_id', $id)->get();

		if ($id != 0) {
			$r = Category::find($id);
			$data['test'] = [ $r->p_id, $r->location, $r->c_id];
		} else {
			$data['test'] = [ 0, 'top'];
		}

		if ($l == 'seminar') {
			$data['notes'] = Notebook::where('c_id', $id)->get();
		}

		return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

	protected function getInput()
	{
		return [
			'p_id'			=>	Input::get('data.p_id') ? Input::get('data.p_id') : 0,
			'c_slug'		=>	Input::get('data.c_slug'),
			'c_name'		=>	Input::get('data.c_name'),
			'c_description'	=>	Input::get('data.c_description'),
			'location'		=>	Input::get('data.location'),
		];
	}
}
