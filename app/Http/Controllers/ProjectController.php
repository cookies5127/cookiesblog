<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input, Markdown;

use App\Models\Project;
use App\Models\ProjectWord;
use App\Models\ProjectThink;
use App\Models\ProjectPlan;
use App\Models\ProjectBug;
use App\Models\ProjectCheck;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Project::orderBy('created_at', 'desc')->get();

		return response()->json($lists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

		$r = Project::firstOrCreate($data);

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
		$id = explode('x', $id);

		$r = Project::find($id[0]);

		$r['words'] = ProjectWord::where('p_id', $id[0])->wher('v_id', $id[1])->orderBy('pw_content', 'asc')->get();
		$r['thinks'] = $this->getThink($id);
		$r['plans'] = $this->getPlan($id);
		$r['bug'] = $this->getBug($id);
		$r['checks'] = ProjectCheck::pro($id)->get();

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
        $r = Project::find($id);

		if ($r->p_status != 5) {
			$data['p_status'] = $r->p_status + 1;
			$r->update($data);
		}
		
		return response()->json($r);
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
		$d = explode('x', $id);
		$r = Project::find($d[0]);
		
		switch ($r->p_status) {
			case 0 : $data = 'prosword';	break;
			case 1 : $data = 'prosthink';	break;
			case 2 : $data = 'prosplan';	break;
			case 3 : $data = 'proslog';		break;
			case 4 : $data = 'prosbug';		break;
			case 5 : $data = 'proscheck';	break;
		}

		return $data;
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
			'v_id'			=>	Input::get('data.v_id') ? Input::get('data.v_id') : '0',
			'p_name'		=>	Input::get('data.p_name'),
			'p_status'		=>	Input::get('data.p_status') ? Input::get('data.p_status') : '0',
			'p_deadline'	=>	Input::get('data.p_deadline'),
			'p_description'	=>	Input::get('data.p_description'),
			'p_result'		=>	Input::get('data.p_result'),
		];
	}

	protected function getThink($id)
	{
		$data = ProjectThink::where('p_id', $id[0])->where('v_id', $id[1])->first();

		if ($data) {
			$data['pt_content'] = Markdown::parse($data['pt_content']);
			$data['pt_check'] = Markdown::parse($data['pt_check']);
			$data['pt_require'] = Markdown::parse($data['pt_require']);
		}

		return $data;
	}

	protected function getBug($id)
	{
		$data['bugs'] = ProjectBug::pro($id)->where('is_finish', '0')->get();
		$data['bugsfinish'] = ProjectBug::pro($id)->where('is_finish', '1')->get();

		return $data;
	}

	protected function getPlan($id)
	{
		$data['finish'] = ProjectPlan::where('p_id', $id[0])->where('v_id', $id[1])->where('pp_log', '<>', 'null')->get();
		$data['plans'] = ProjectPlan::where('p_id', $id[0])->where('v_id', $id[1])->where('pp_log', null)->get();

		return $data;
	}
}
