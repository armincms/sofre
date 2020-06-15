<?php
namespace Armincms\Sofre; 
  
use Component\Tagging\Contracts\Taggable;
use Component\Tagging\Concerns\HasTag;
use Armincms\Category\InteractsWithCategories;
use Core\Crud\Concerns\HasCustomImage; 
use Core\User\Contracts\Ownable;
use Core\User\Concerns\HasOwner; 
use Core\Crud\Contracts\Publicatable;
use Core\Crud\Concerns\Publishing;
use Core\Crud\Contracts\SearchEngineOptimize as SEO;
use Core\Crud\Concerns\SearchEngineOptimizeTrait as SEOTrait;
use Core\HttpSite\Contracts\Linkable;  
use Core\HttpSite\Contracts\Hitsable;
use Core\HttpSite\Concerns\Visiting;
use Core\HttpSite\Concerns\IntractsWithSite;
use Core\HttpSite\Component; 
use Armincms\Facility\Facilities;
use Armincms\Location\Location; 

class Restaurant extends Model implements Publicatable, SEO, Linkable, Hitsable
{ 
    use InteractsWithCategories;
    use Facilities, Publishing, SEOTrait, Permalink, Visiting, IntractsWithSite; 
 
    protected $publishStatus = 'approved'; 

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['translations', 'categories'];

    protected $append = [
        'menu', 'service_range', 'serving_start', 'serving_end'
    ];

    protected $casts = [  
        'contacts'      => 'json',
        'payment_method'=> 'json',
        'sending_method'=> 'json', 
        'min_order'     => 'double',
    ];
 
    protected $medias = [
        'logo' => [ 
            'multiple' => false,
            'disk'  => 'armin.image',
            'schemas' => [
                'logo', 'icon', 'thumbnail'
            ]
        ], 
        'gallery' => [
            'multiple' => true,
            'disk'  => 'armin.image',
            'schemas' => [
                'restaurant', 'restaurant.list', '*'
            ]
        ], 
        'video' => [
            'disk'  => 'armin.video'
        ]
    ];

    public static function boot()
    { 
        parent::boot();

        self::saved(function($model) {  
            if($model->workingDays()->count() < 7) {
                $data = WorkingDay::get()->keyBy('id')->map(function($day) {
                    return collect(Helper::meals())->map(function($label, $meal){ 
                         return Helper::defaultMealDuration($meal);
                    }); 
                });

                $model->workingDays()->sync($data->toArray());
            }
        });
    }

    public function component() : Component
    {
        return new \Component\RestaurantServices\Components\RestaurantComponent;
    }

    public function serviceRanges()
    {
        return $this->zones();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function zone()
    {
        return $this->belongsTo(Location::class);
    }

    public function zones()
    {
        return $this->belongsToMany(Location::class, Helper::table('restaurant_location'))
                    ->withPivot('duration', 'cost', 'description');
    }

    public function restaurantClass()
    {
        return $this->belongsTo(RestaurantClass::class);
    } 

    public function workingDays()
    {
        $pivots = collect(Helper::meals())->keys()->push('description')->all();

        return $this
                ->belongsToMany(WorkingDay::class, Helper::table('restaurant_working_day'))
                ->withPivot($pivots )
                ->using(WorkingDayPivot::class);
    }

    public function workingHours()
    {
        $this->relationLoaded('workingDays') || $this->load('workingDays');

        return Helper::fillWeekMeals(function($meal, $day) {
            if($day = $this->workingDays->where('day', $day)->first()) {
                return $day->pivot->{$meal}; 
            } 
        }); 
    }  

    public function getTranslationModel()
    {
        return Translation::withSluggable('name');
    }

    public function getServiceRangeAttribute()
    {
        return $this->zones->map(function($location) {
            return [
                'range'     => $location->title,
                'location'  => $location->id,
                'cost'      => $location->pivot->cost,
                'currency'  => "IRR",
                'duration'  => $location->pivot->duration,
            ];
        });
    } 

    public function getCurrentMealDuration()
    {  

        return [
            'from'  => null,
            'until' => null,
        ];
        return $this->mealDuration($this->guessMealName(), $this->guessTodayName());
    }

    public function getServingStartAttribute()
    { 
        return $this->getCurrentMealDuration()['from'];
    } 

    public function getServingEndAttribute()
    {
        return $this->getCurrentMealDuration()['until'];
    }

    public function getMenuAttribute()
    {
        $this->relationLoaded('foods') || $this->load('foods');
        $meal = $this->guessMealName();
        $day  = $this->guessTodayName();
        $foodGroups  = FoodGroup::get();

        return $this->foods->filter(function($food) use ($meal, $day) {
            $menu = $food->pivot;
            
            return $menu->meal == $meal && $menu->day == $day; 
        })->groupBy('food_group_id')->map(function($group, $key) use ($foodGroups) {
            return [
                'group' => $foodGroups->where('id', $key)->first()->title,
                'foods' => $group->map(function($food) use ($group) {
                    return [
                        'id'        => $food->id, 
                        'name'      => $food->title, 
                        'material'  => $food->material, 
                        'price'     => $food->price(), 
                        'oldPrice'  => $food->oldPrice(), 
                        'discount'  => $food->discountPercent(), 
                        'currency'  => currency()->getCurrency($food->currency)['symbol'] ??'IRR',
                        'image'     => $food->image,
                    ];
                }),
            ]; 
        })->values(); 
    } 

    public function guessMealName()
    {
        return 'lunch';
    }

    public function guessTodayName()
    {
        return mb_strtolower(now()->format('l'));
    }

    public function foods()
    { 
        $pivotColumns = collect(Helper::days())->keys()->merge([
            'available', 'order', 'id'
        ]);

        return $this->belongsToMany(Food::class, Helper::table('restaurant_food'))
                    ->withPivot($pivotColumns->all())
                    ->using(Menu::class);
    }

    public function foodGroups()
    {
    	return $this->belongsToMany(FoodGroup::class, 'restaurant_menus')->withPivot([
            'days', 'meals', 'status', 'price', 'unit_price'
        ]); 
    }   
 
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'restaurant_location')->withPivot([
            'cost', 'duration', 'description'
        ]);
    }

    public function mainBranch()
    {
        return $this->belongsTo(static::class, 'branch_id');
    }

    public function branches()
    {
        return $this->hasMany(static::class, 'branch_id');
    }

    public function isBranch()
    {
        return $this->branche_status === 'branch';
    }

    public function formDetailsAttribute()
    {
        return $this->details->pluck('id')->toArray();
    }

    public function formFeaturesAttribute()
    {
        return $this->details->pluck('pivot.value')->dd();
    } 

    public function averageDeliveryTime()
    {
        return $this->zones->avg('pivot.duration');
    }

    public function averageShippingCost()
    {
        return $this->zones->avg('pivot.cost');
    }
}
