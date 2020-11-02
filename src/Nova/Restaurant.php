<?php

namespace Armincms\Sofre\Nova;
  
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Panel;    
use Laravel\Nova\Http\Requests\NovaRequest; 
use Laravel\Nova\Fields\{ID, Text, Number, Boolean, Select, BelongsTo, HasMany, MorphMany, BelongsToMany}; 
use Inspheric\Fields\Url; 
use NovaItemsField\Items; 
use Zareismail\RadioField\RadioButton;   
use OptimistDigital\MultiselectField\Multiselect;  
use SadekD\NovaOpeningHoursField\NovaOpeningHoursField;
use Armincms\Fields\{Targomaan, BelongsToMany as ManyToMany};
use Armincms\NovaComment\Nova\Comment;
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
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'chain', 'type'
    ];

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
                    ->authenticate()
                    ->orWhere('private', false);
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
                    ->whereBranching('chained')
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
                ->onlyOnDetail(), 

            RadioButton::make(__("Branch"), 'branching')
                ->options(Helper::branching())
                ->default(request()->viaResourceId ? 'branch' : 'independent')
                ->hideFromIndex()
                ->marginBetween()  
                ->toggle([ 
                    'independent' => ['chain', 'branch'], 
                    'branch' => ['name'], 
                    'chained' => [
                        'branch', 'type', 'chain', 'foods', 'areas', 'image', 'online',
                        'sending_method', 'payment_method', 'working_hours', 'zone', 
                        'contacts->address', 'contacts->url', 'contacts->phones'
                    ], 
                ]),

            Boolean::make(__('Online'), 'online') 
                ->sortable()
                ->required()
                ->rules('required')
                ->default(true),

            BelongsTo::make(__('Restaurant Type'), 'type', RestaurantType::class)
                ->withoutTrashed()
                ->sortable()
                ->required() 
                ->nullable($request->get('branching') === 'chained'),

            BelongsTo::make(__('Chain'), 'chain', Restaurant::class)
                ->withoutTrashed() 
                ->sortable()
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

            $this->priceField(__('Minimum Order Price'), 'min_order')
                ->hideFromIndex(), 

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


            ManyToMany::make(__("Service Areas"), 'areas', Zone::class)
                ->fields(new Fields\Areas)
                ->pivots()
                ->hideFromIndex(),

            $this->imageField(__('Logo'), 'logo')
                    ->conversionOnPreview('common-thumbnail') 
                    ->conversionOnDetailView('common-thumbnail') 
                    ->conversionOnIndexView('common-thumbnail'),

            $this->imageField(__('Featured Image'))
                ->conversionOnPreview('common-thumbnail') 
                ->conversionOnDetailView('common-thumbnail') 
                ->conversionOnIndexView('common-thumbnail')
                ->hideFromIndex(), 

            new Panel(__('Working Hours'), [    
                NovaOpeningHoursField::make(__('Working Hours'), 'working_hours')
                    ->hideFromIndex(),
            ]),  

            // BelongsToMany::make(__('Menu'), 'foods', Food::class)
            //     ->fields(new Fields\Menu)
            //     ->hideFromDetail(optional($this->resource)->branching === 'chained'), 

            HasMany::make(__('Branches'), 'branches', static::class)
                ->hideFromDetail(optional($this->resource)->branching !== 'chained'), 

            new Panel(__('Contact us'), [   
                BelongsTo::make(__('Restaurant Location'), 'zone', Zone::class)
                    ->withoutTrashed()
                    ->nullable(),

                Text::make(__('Restaurant Address'), 'contacts->address')
                    ->hideFromIndex(),

                Url::make(__('Restaurant Website'), 'contacts->url')
                    ->hideFromIndex(),

                Items::make(__('Phone Numbers'), 'contacts->phones')
                    ->hideFromIndex(),
            ]),  

            MorphMany::make(__('Comments'), 'comments', Comment::class), 
        ]; 
    } 

    public function isUpdateOrCreationRequest(Request $request)
    {
        return  $request->isCreateOrAttachRequest() || 
                $request->isUpdateOrUpdateAttachedRequest();
    }  

    public function isBranchRequest(Request $request)
    {  
        return  $this->isUpdateOrCreationRequest($request) && 
                $request->get('branching') === 'branch';
    } 

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\Location,
            new Filters\Chain,
            new Filters\Type,
        ];
    }
}
