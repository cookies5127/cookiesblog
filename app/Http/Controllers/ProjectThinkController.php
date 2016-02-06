<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Models\ProjectThink;

class ProjectThinkController extends Controller
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
        $data = $this->getThink();
		$id = Input::get('data.pt_id');
		
		if ($id) {
			$r = ProjectThink::find($id)->update($data);
		} else {
			$r = ProjectThink::firstOrCreate($data);
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
        $data = ProjectThink::find($id);

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

	protected function getThink()
	{
		return [
			'p_id'			=>	Input::get('data.p_id'),
			'v_id'			=>	Input::get('data.v_id'),
			'pt_content'	=>	Input::get('data.pt_content'),
			'pt_require'	=>	Input::get('data.pt_require'),
			'pt_check'		=>	Input::get('data.pt_check'),
			'pt_expect'		=>	Input::get('data.pt_expect'),
		];
	}
}
