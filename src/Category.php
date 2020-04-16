<?php
namespace Armincms\Sofre; 
 
use Armincms\Category\Category as Model;   

class Category extends Model  
{     
    public function relatedResource() : string
    {
    	return Nova\Restanrant::class;
    }
}
