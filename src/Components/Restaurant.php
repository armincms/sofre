<?php 
namespace Armincms\Sofre\Components;
 
use Illuminate\Http\Request; 
use Core\HttpSite\Component;
use Core\HttpSite\Contracts\Resourceable;
use Core\HttpSite\Concerns\IntractsWithResource;
use Core\HttpSite\Concerns\IntractsWithLayout;
use Core\Document\Document;
use Armincms\Sofre\Models\Restaurant as RestaurantModel;
use Armincms\Sofre\Nova\Setting;

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
		])->with(['foods' => function($query) {
			$query->with('group', 'media');
		}, 'discounts', 'media', 'areas'])->firstOrFail(); 

		$this->resource($restaurant);  

		$docuemnt->title($restaurant->name); 
		
		$docuemnt->description($restaurant->name);    

		return (string) $this->firstLayout($docuemnt, $this->config('layout'), 'callisto')
					->display($restaurant->toArray(), $docuemnt->component->config('layout', [])); 
	}    

	/**
	 * Returns the avaialbe FoodGroup`s.
	 * 
	 * @return \Illuminate\Database\Eloqeunt\Collection
	 */
	public function foodGroups()
	{
		return $this->resource->foods->map->group->unique();
	}

	/**
	 * Returns the avaialbe FoodGroup`s.
	 * 
	 * @return \Illuminate\Database\Eloqeunt\Collection
	 */
	public function groupedFoods()
	{
		return $this->resource->foods->grouped();
	}

	/**
	 * Apply restaurant discount on the food.
	 * 
	 * @param  \Illuminate\Database\Eloqeunt\Model $food 
	 * @return float       
	 */
	public function applyDiscount($food)
	{
		return $this->resource->discounts->applyOn($food);
	}

	public function currency()
	{
		return Setting::currencyCode();
	} 

    /**
     * Get the restaurant featured image.
     *      
     * @return string              
     */
	public function image()
	{
		return $this->resource->featuredImage('common-main');
	}

    /**
     * Get the restaurant image logo.
     *      
     * @return string              
     */
	public function logo()
	{
		return $this->resource->featuredImage('restaurant-logo', 'logo');
	}

    /**
     * Get the restaurant image logo.
     *      
     * @return string              
     */
	public function courierPrice()
	{
		return $this->resource->maxCourierTime();
	}

    /**
     * Get the restaurant image logo.
     *      
     * @return string              
     */
	public function courierTime()
	{
		return $this->resource->maxCourierTime();
	}

	/**
	 * Retruns the workinghours.
	 * 
	 * @return array
	 */
	public function workingHours()
	{
		return $this->resource->working_hours;
	}
}
