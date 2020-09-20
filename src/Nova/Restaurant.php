<?php

namespace Armincms\Sofre\Nova;
  
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Panel;    
use Laravel\Nova\Http\Requests\NovaRequest; 
use Laravel\Nova\Fields\{ID, Text, Textarea, Number, Boolean, Select, BelongsTo, BelongsToMany}; 
use Inspheric\Fields\Url; 
use NovaItemsField\Items;
use Laraning\NovaTimeField\TimeField; 
use OwenMelbz\RadioField\RadioButton;   
use OptimistDigital\MultiselectField\Multiselect; 
use Armincms\Fields\{Targomaan, BelongsToMany as ManyToMany};
use Armincms\Location\Nova\Zone;  
use Armincms\Json\Json;
use Armincms\Sofre\Helper;


class Restaurant extends Resource  
{ 
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Restaurant::class;  

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableFoods(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query) 
                    ->whereIn('restaurant_id', [null, $request->resourceId])
                    ->authenticate();
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableRestaurants(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query) 
                    ->whereCenter(1)
                    ->authenticate();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()
                ->sortable(),  

            Number::make(__('Hits'), 'hits')
                ->exceptOnForms(), 

            RadioButton::make(__("Branch"), 'center')
                ->options([
                    '0' => __("Independent"),
                    'false' => __("Branch"),
                    '1' => __("Chained"),
                ])
                ->default(request()->viaResourceId ? 'false' : '0')
                ->marginBetween()  
                ->toggle([ 
                    '0' => ['chain', 'branch'], 
                    '1' => ['branch', 'type', 'chain', 'foods', 'areas', 'sending_method', 'payment_method', 'image', 'online'], 
                    'false' => ['name'], 
                ])
                ->fillUsing(function($request, $model) { 
                    $model->center = intval($request->center);   
                })
                ->resolveUsing(function($value, $resource, $attribute) { 
                    return intval($value) ? '1' : (intval($resource->chain_id) ? 'false' : '0');
                }),

            Boolean::make(__('Online'), 'online') 
                ->required()
                ->rules('required')
                ->default(true),

            BelongsTo::make(__('Restaurant Type'), 'type', RestaurantType::class)
                ->withoutTrashed()
                ->required() 
                ->nullable(intval($request->get('center')) === 1),

            BelongsTo::make(__('Chain'), 'chain', Restaurant::class)
                ->withoutTrashed() 
                ->nullable(! $this->isBranchRequest($request)), 

            Text::make(__('Name'), 'name')
                ->required()
                ->rules($this->isBranchRequest($request) ? null : 'required')
                ->onlyOnForms(),

            Text::make(__('Branch Name'), 'branch')
                ->required()
                    ->rules($this->isBranchRequest($request) ? 'required' : null)
                ->onlyOnForms()
                ->fillUsing(function($request, $model, $attribute, $requestAttribute) {
                    if($this->isBranchRequest($request)) {
                        $model->name = $request->get($attribute); 
                    }
                })
                ->resolveUsing(function($value, $resource, $attribute) {
                    return $resource->name;
                })
                ->help(__('This name comes after the branch name')), 
            
            Multiselect::make(__("Sending Method"), 'sending_method')
                ->options($sendingMethods = Helper::sendingMethod())
                ->default(array_keys($sendingMethods))
                ->rules('required')
                ->saveAsJSON()
                ->hideFromIndex(),

            Multiselect::make(__("Payment Method"), 'payment_method')
                ->options($paymentMethods = Helper::paymentMethods())
                ->default(array_keys($paymentMethods))
                ->rules('required')
                ->saveAsJSON()
                ->hideFromIndex(), 

            $this->priceField(__('Minimum Order Price'), 'min_order'), 

            ManyToMany::make(__('Categories'), 'categories', Category::class) 
                ->hideFromIndex(),  
            
            ManyToMany::make(__('Menu'), 'foods', Food::class)
                ->fields(new Fields\Menu)
                ->pivots()
                ->fillUsing(function($pivots) {
                    return collect($pivots)->map(function($pivot) {
                        return is_array($pivot) ? implode(',', $pivot) : $pivot;
                    })->all();
                })
                ->hideFromIndex(),

            BelongsToMany::make(__('Menu'), 'foods', Food::class)
                ->fields(new Fields\Menu), 


            ManyToMany::make(__("Service Areas"), 'areas', Zone::class)
                ->fields(new Fields\Areas)
                ->pivots()
                ->hideFromIndex(),

           $this->imageField(__('Logo'), 'logo'),

           $this->imageField(__('Featured Image'))
                ->hideFromIndex(),

            new Panel(__('Media'), [
            ]),

            new Panel(__('Contact us'), [   
                BelongsTo::make(__('Restaurant Location'), 'zone', Zone::class)
                    ->withoutTrashed()
                    ->nullable(),

                Text::make(__('Restaurant Address'), 'contacts->address'),

                Url::make(__('Restaurant Website'), 'contacts->url'),

                Items::make(__('Phone Numbers'), 'contacts->phones'),
            ]),  
        ]; 
    } 

    public function isUpdateOrCreationRequest(Request $request)
    {
        return $request->isCreateOrAttachRequest() || $request->isUpdateOrUpdateAttachedRequest();
    }  

    public function isBranchRequest(Request $request)
    {  
        return $this->isUpdateOrCreationRequest($request) && $request->get('center') === 'false';
    }  
}
