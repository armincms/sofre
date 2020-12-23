<?php
namespace Armincms\Sofre\Models; 
 
use Armincms\Category\Category as Model;   

class Category extends Model  
{     
    public function relatedResource() : string
    {
    	return \Armincms\Sofre\Models\Nova\Restanrant::class;
    }
}
