<?php

namespace Armincms\Sofre\Observers;

use Illuminate\Support\Str;

class OrderObserver
{
	public function saved($model)
	{
		$event = '\\Armincms\\Sofre\\Events\\' . Str::studly($model->getMarkedAsValue());

		if($model->isDirty($model->getMarkedAsColumn()) && class_exists($event)) {  
			event(new $event($model));
		} 
	}
}
