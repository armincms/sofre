<?php 
namespace Armincms\Sofre\Components;
 
use Illuminate\Http\Request; 
use Core\HttpSite\Component;
use Core\HttpSite\Contracts\Resourceable;
use Core\HttpSite\Concerns\IntractsWithResource;
use Core\HttpSite\Concerns\IntractsWithLayout;
use Core\Document\Document;
use Armincms\Sofre\Models\Restaurant as RestaurantModel;

class Restaurant extends Component implements Resourceable
{       
	use IntractsWithResource, IntractsWithLayout;

	/**
	 * Route Conditions of section
	 * 
	 * @var null
	 */
	protected $wheres = [ 
		'id'	=> '[0-9]+'
	];   

	public function toHtml(Request $request, Document $docuemnt) : string
	{       
		$restaurant = RestaurantModel::where([
			'url' 	=> $request->relativeUrl(),
			'locale'=>  app()->getLocale(),
		])->firstOrFail(); 

		$this->resource($restaurant);  

		$docuemnt->title($restaurant->metaTitle()?: $restaurant->name); 
		
		$docuemnt->description($restaurant->metaDescription()?: $restaurant->name);   

		return $this->firstLayout($docuemnt, $this->config('layout'), 'citadel')
					->display($restaurant->toArray(), $docuemnt->component->config('layout', [])); 
	}    
}
