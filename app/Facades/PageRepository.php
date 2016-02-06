<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PageRepository extends Facade
{
	
	protected static function getFacadeAccessor()
	{
		return 'pagerepository';
	}

}
