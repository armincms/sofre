<?php

namespace Armincms\Sofre\Nova\Categorizables;
 
use Illuminate\Http\Request;
use Armincms\Categorizable\Nova\Categorizable as Resource;

class Restaurant extends Resource
{   

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fields(Request $request): array
    {
    	return [
    	];
    }
}
