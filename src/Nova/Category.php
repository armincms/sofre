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
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Models\Category::class; 
}
