<?php 
namespace Armincms\Sofre\Components;
 
use Illuminate\Http\Request; 
use Core\HttpSite\Component; 
use Core\HttpSite\Concerns\IntractsWithLayout;
use Core\Document\Document;
use Armincms\Sofre\Nova\Setting;
use Armincms\Sofre\Models\Restaurant;

class SearchRestaurant extends Component
{       
	use IntractsWithLayout;

	/**
	 * Route of Component.
	 * 
	 * @var null
	 */
	protected $route = 'restaurant/search';

	/**
	 * Route Conditions of section
	 * 
	 * @var null
	 */
	protected $wheres = [  
	];  


	protected $restaurants;

	public function toHtml(Request $request, Document $docuemnt) : string
	{        
		$docuemnt->title(__('Search Restaurants')); 
		
		$docuemnt->description(__('Search Restaurants'));   

		return (string) $this->firstLayout($docuemnt, $this->config('layout'), 'clean-sofre-search')
					->display(); 
	}  

	public function restaurants()
	{ 
		if(! isset($this->restaurants)) {
			$this->restaurants = Restaurant::withoutBranchs()
									->with('categories', 'type', 'foods', 'discounts')
									->paginate();
		}

		return $this->restaurants;
	}  

	public function reviewLayout(Document $docuemnt)
	{
		return $this->firstLayout(
			$docuemnt, $this->config('sfore.layout.restaurant.review', 'ethereal'), 'clean-sofre-restaurant-review'
		);
	}

	public function restaurantInformation($restaurant)
	{
		return array_merge($restaurant->toArray(), [
			'url' 	=> $restaurant->getUrl(),
			'image' => $restaurant->featuredImage('common-thumbnail'),
			'logo' 	=> $restaurant->featuredImage('restaurant-logo', 'logo'),
			'discount'=> $restaurant->averageDiscount(),
			'courier' => currency_format($restaurant->maxCourierPrice(), Setting::currencyCode()),
			'isOpen'  => $restaurant->isOpen(),
			'nextOpening' => $restaurant->nextOpening()->diffForHumans(),
		]);
	}
}
