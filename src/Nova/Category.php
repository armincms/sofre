<?php

namespace Armincms\Sofre\Nova;
  
use Armincms\Categorizable\Nova\Category as Resource;

class Category extends Resource
{   
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Restaurant Services'; 

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'sofre-' . parent::uriKey();
    }

    public function categorizables() : array
    {
    	return [
    		Categorizables\Restaurant::class,
    	];
    }
}
