<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Models\Todolist;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['todo'] = Todolist::orderBy('td_sort', 'asc')->where('is_finish', '0')->get();
        $data['finish'] = Todolist::where('is_finish', '1')->get();
		
		return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->getInput();
		$id = Input::get('data.td_id');

		if ($id) {
			$r = Todolist::find($id)->update($data);
		} else {
			$r = Todolist::firstOrCreate($data);
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
        $data = Todolist::find($id);

		return response()->json($data);
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
        //
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
		$r = [
			'danger'	=>	1,
			'warning'	=>	2,
			'info'		=>	3,
			'default'	=>	4,
		];

		$sort = $r[Input::get('data.td_type')];

		return [
			'td_name'	=>	Input::get('data.td_name'),
			'td_expect'	=>	Input::get('data.td_expect'),
			'td_result'	=>	Input::get('data.td_result'),
			'td_type'	=>	Input::get('data.td_type'),
			'td_sort'	=>	$sort,
			'is_finish'	=>	Input::get('data.td_result') ? 1 : 0,
		];
	}
}
