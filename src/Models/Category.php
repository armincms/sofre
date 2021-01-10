<?php

namespace Armincms\Sofre\Models;
    
use Armincms\Categorizable\Category as Model;
use Core\HttpSite\Component;   

class Category extends Model  
{    
    /**
     * Get the interface of scoped resources.
     * 
     * @return string
     */
    public static function resourcesScope() : string
    {
        return Restaurant::class;
    }

    public function component() : Component
    {
    	return new \Armincms\Sofre\Components\Category;
    }
}
