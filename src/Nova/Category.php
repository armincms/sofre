<?php

namespace Armincms\Sofre\Nova;
  
use Armincms\Category\Nova\Resource;

class Category extends Resource
{ 
    public static function relatableResource()
    {
    	return Restaurant::class;
    }
}
