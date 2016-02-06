<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Models\Month;

class MonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $time = date('Y-m');
		$data['lists'] = Month::where('m_when', 'like', '%'.$time.'%')->where('m_result', null)->get();
		$data['finish'] = Month::where('m_when', 'like', '%'.$time.'%')->where('m_result', '<>', 'null')->get();

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
		$id = Input::get('data.m_id');

		if ($id) {
			$r = Month::find($id)->update($data);
		} else {
			$r = Month::firstOrCreate($data);
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
        $r = Month::find($id);

		return response()->json($r);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
		return [
			'm_name'	=>	Input::get('data.m_name'),
			'm_when'	=>	Input::get('data.m_when'),
			'm_expect'	=>	Input::get('data.m_expect'),
			'm_result'	=>	Input::get('data.m_result'),
			'm_cost'	=>	Input::get('data.m_cost'),
		];
	}
}
