<?php 
namespace Armincms\Sofre\Components;
  
use Illuminate\Http\Request; 
use Armincms\Categorizable\Components\Category as Component;

class Category extends Component 
{     
	/**
	 * Get the resource query builder.
	 * 
	 * @param  Request $request 
	 * @return \Illuminate\Database\Elqoeunt\Model           
	 */
	public function newModel(Request $request)
	{
		return new \Armincms\Sofre\Models\Category;
	}
}
