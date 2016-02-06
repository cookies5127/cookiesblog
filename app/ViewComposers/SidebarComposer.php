<?php
namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Metas;

class SidebarComposer
{
	protected $nav = [];

	public function __construct()
	{
	}

	public function compose(View $view)
	{
		$view->with('tags',Metas::sidebar());
	}

}
