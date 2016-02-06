<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Models\Schedule;
use App\Models\ScheduleSummary;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$time = date('Y-m-d');

        $data['lists'] = Schedule::where('created_at', 'like', '%'.$time.'%')->orderBy('created_at', 'desc')->get();
		$data['summary'] = ScheduleSummary::where('created_at', 'like', '%'.$time.'%')->first();

		return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$today = date('Y-m-d');

		return response()->json($today);
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

		$update = Schedule::orderBy('created_at', 'desc')->first();
		if (!$update->s_update) {
			$r = $update->update(['s_update' => 1]);
			$minute = intval((strtotime($update->updated_at) - strtotime($update->created_at))/60);
			$cost = intval($minute/45);
			$info = $update->update(['s_cost' => $cost, 's_minute' => $minute]);
		}
		if ($update->s_slug != $data['s_slug']) {
			$info = Schedule::create($data);
		}

		return response()->json($info);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['lists'] = Schedule::where('created_at', 'like', '%'.$id.'%')->orderBy('created_at', 'desc')->get();
		$data['summary'] = ScheduleSummary::where('created_at', 'like', '%'.$id.'%')->first();

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
		$score = $this->getScore();
		$info = $this->getInfo();
        $data = $this->getSummary($score, $info);

		$date = date('Y-m-d');

		$check = ScheduleSummary::where('created_at', 'like', '%'.$date.'%')->first();
		if ($check) {
			$r = ScheduleSummary::find($check->ss_id)->update($data);
		} else {
			$r = ScheduleSummary::create($data);
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
		$type = [
			'getup'		=>	'warning',
			'work'		=>	'primary',
			'learning'	=>	'success',
			'exercise'	=>	'info',
			'waste'		=>	'danger',
			'finish'	=>	'default',
		];

		$date = date('Y-m-d');
		$check = Input::get('data.s_slug');
		if ($check == 'getfin') {
			$g = Schedule::where('s_slug', 'getup')->where('created_at', 'like', '%'.$date.'%')->first();
			$f = Schedule::where('s_slug', 'finish')->where('created_at', 'like', '%'.$date.'%')->first();
			if ($g && $f) {
				return false;
			} elseif ($g) {
				$slug = 'finish';
			} else {
				$slug = 'getup';
			}
		} else {
			$slug = Input::get('data.s_slug');
		}

		return [
			's_name'	=>	Input::get('data.s_name'),
			's_slug'	=>	$slug,
			's_type'	=>	$type[$slug],
		];
	}

	protected function getSummary($data, $info)
	{
		return [
			'ss_content'	=>	Input::get('data'),
			'ss_score'		=>	$data['total'],
			'ss_work'		=>	$info['work'],
			'ss_exercise'	=>	$info['exercise'],
			'ss_learning'	=>	$info['learning'],
			'ss_getup'		=>	$info['getup'],
			'ss_waste'		=>	$info['waste'],
			'ss_finish'		=>	$info['finish'],
		];
	}

	protected function getScore()
	{
		$info = $this->getInfo();

		$score['getup'] = $info['getup'] > 0 ? 0 : 10;
		$score['finish'] = $info['finish'] < 0 ? 0 : 10;
		$score['waste'] = $info['waste'] >= 20 ? 0 : 20 - $info['waste'];
		$score['work'] = $info['work'] <= 40 ? $info['work'] : 40;
		$score['exercise'] = $info['exercise'] <= 10 ? $info['exercise'] : 10;
		$score['learning'] = $info['learning'] <= 30 ? $info['learning'] : 30;
		$score['total'] = $score['work'] + $score['waste'] + $score['exercise'] + $score['learning'];

		return $score;
	}

	protected function getTime()
	{
		$time['getup'] = Schedule::total('getup');
		$time['finish'] = Schedule::total('finish');
		$time['learning'] = Schedule::slug('learning');
		$time['waste'] = Schedule::slug('waste');
		$time['work'] = Schedule::slug('work');
		$time['exercise'] = Schedule::slug('exercise');
		$time['total'] = round((strtotime($time['finish']) - strtotime($time['getup']))/60);

		return $time;
	}

	protected function getInfo()
	{
		$time = $this->getTime();

		$info['exercise'] = round($time['exercise'][0]/$time['total']*100);
		$info['work'] = round($time['work'][0]/$time['total']*100);
		$info['learning'] = round($time['learning'][0]/$time['total']*100);
		$info['waste'] = round($time['waste'][0]/$time['total']*100);
		$info['getup'] = round((strtotime($time['getup']) - strtotime(date('Y-m-d').' 06:30:00'))/60);
		$info['finish'] = round((strtotime($time['finish']) - strtotime(date('Y-m-d').' 22:30:00'))/60);

		return $info;
	}
}
