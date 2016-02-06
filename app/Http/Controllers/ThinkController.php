<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Models\Think;
use App\Models\ThinkWord;

class ThinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Think::get();
		foreach ($data as $k=>$v) {
			$son = ThinkWord::where('t_id', $v->t_id)->get();
			$data[$k]['words'] = $son;
		}

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
        $id = Input::get('data.t_id');
		$data = $this->getThink();

		if ($id) {
			$r = Think::find($id)->update($data);
		} else {
			$r = Think::firstOrCreate($data);
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
        $data = Think::find($id);
		$data['words'] = ThinkWord::where('t_id', $id)->orderBy('tw_content', 'asc')->get();

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
		$data = ThinkWord::find($id);

		return response()->json($data);
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
        $twid = Input::get('data.tw_id');
		$data = $this->getWord($id);

		if ($twid) {
			$r = ThinkWord::find($twid)->update($data);
		} else {
			$r = ThinkWord::firstOrCreate($data);
		}

		return response()->json($r);
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
			'title'		=>	Input::get('data.title'),
			'body'		=>	Input::get('data.body'),
		];
	}

	protected function getWord($id)
	{
		return [
			't_id'			=>	$id,
			'tw_word'		=>	Input::get('data.tw_word'),
			'tw_content'	=>	Input::get('data.tw_content'),
		];
	}
}
