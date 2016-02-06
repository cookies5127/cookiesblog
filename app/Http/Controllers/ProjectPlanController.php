<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Models\ProjectPlan;

class ProjectPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
		$id = Input::get('data.pp_id');

		if ($id) {
			$r = ProjectPlan::find($id)->update($data);
		} else {
			$r = ProjectPlan::firstOrCreate($data);
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
        $data = ProjectPlan::find($id);

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
        $data = $this->getLog();

		$r = ProjectPlan::find($id)->update($data);

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
			'p_id'			=>	Input::get('data.p_id'),
			'v_id'			=>	Input::get('data.v_id'),
			'pp_when'		=>	Input::get('data.pp_when'),
			'pp_what'		=>	Input::get('data.pp_what'),
			'pp_cost'		=>	Input::get('data.pp_cost'),
			'pp_fact_cost'	=>	Input::get('data.pp_fact_cost'),
			'pp_log'		=>	Input::get('data.pp_log'),
		];
	}

	protected function getLog()
	{
		return [
			'pp_log'		=>	Input::get('data.pp_log'),
			'pp_fact_cost'	=>	Input::get('data.pp_fact_cost'),
		];
	}
}
