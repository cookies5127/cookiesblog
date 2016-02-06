<?php
namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use DB;
use App\Models\Navbar;

class NavComposer
{
	protected $nav = [];

	public function __construct()
	{
	}

	public function compose(View $view)
	{
		$view->with('nav',Navbar::nav());
		$view->with('drop',Navbar::drop());
	}

}
