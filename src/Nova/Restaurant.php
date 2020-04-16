<?php

namespace Armincms\Sofre\Nova;
 
use Armincms\Tab\Tab;
use Armincms\Json\Json;
use Armincms\Sofre\Helper;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Textarea; 
use Laravel\Nova\Fields\KeyValue; 
use Laravel\Nova\Fields\Number; 
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Heading;  
use Laravel\Nova\Fields\Select;   
use Laravel\Nova\Fields\BelongsTo;   
use Laravel\Nova\Fields\BelongsToMany;   
use GeneaLabs\NovaGutenberg\Gutenberg;
use Laravel\Nova\Fields\MorphedByMany; 
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;
use Armincms\Facility\Facility;
use OptimistDigital\MultiselectField\Multiselect;
use Benjacho\BelongsToManyField\BelongsToManyField; 
use Armincms\Location\Nova\Zone;  
use Laraning\NovaTimeField\TimeField;
use Armincms\Nova\Fields\Images;
use Armincms\Nova\Fields\Video; 
use OwenMelbz\RadioField\RadioButton; 


class Restaurant extends Resource  
{ 
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\Sofre\Restaurant';  

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
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return array_merge(
            Tab::make('primary', function($tab) {
                $tab->group(__('General'), [$this, 'generalFeilds']);
                $tab->group(__('Payment'), [$this, 'paymentFeilds']);
                $tab->group(__('Media'), [$this, 'mediaFeilds']); 
                // $tab->group(__('SEO'), [$this, 'seoFields']);
            })->toArray(), $this->relations()
        );
    } 

    public function generalFeilds()
    {
        return $this->merge([
            ID::make()->sortable(), 

            BelongsTo::make(__("Restaurant Class"), 'restaurantClass', RestaurantClass::class)
                ->required()
                ->withoutTrashed(),

            Select::make(__("Status"), 'status')
                ->options([
                    'pending' => __("Pending"),
                    'approved' => __("Approved"),
                    'closed' => __("Closed"),
                ])
                ->default('pending')
                ->rules('required'),

            RadioButton::make(__("Branch"), 'center')
                ->options([
                    '0' => __("Independent"),
                    '1' => __("Central Branch"),
                    'false' => __("Under The Branch") 
                ])
                ->default(request()->viaResourceId ? 'false' : '0')
                ->marginBetween() 
                ->toggle([ 
                    '0' => ['branch'], 
                ])
                ->fillUsing(function($request, $model) { 
                    $model->center = boolval($request->center);   
                }),


            BelongsTo::make(__("Branch Name"), 'branch', Branch::class)
                ->withoutTrashed()
                ->withMeta([
                    'singularLabel' => __("Branch Name")
                ])
                ->nullable(),



            // BelongsToManyField::make(__("Categories"), 'categories', Category::class), 


            $this->descriptions(),   
        ]);
    }

    public function paymentFeilds()
    {
        return $this->merge([
            Multiselect::make(__("Sending Method"), 'sending_method')
                ->options([
                    'serve'     => __('Serve'),
                    'delivery'  => __('Delivery At Restaurant'),
                    'courier'   => __('Courier'),
                ])
                ->default(['serve', 'delivery', 'courier'])
                ->rules('required')
                ->saveAsJSON(),

            Multiselect::make(__("Payment Method"), 'payment_method')
                ->options([
                    'pos'      => __('POS'),
                    'online'   => __('Online'),
                    'cash'     => __('Cash'),
                    'credit'   => __('Credit'),
                ])
                ->default(['pos', 'online', 'cash'])
                ->rules('required')
                ->saveAsJSON(), 
        ]);
    }

    public function mediaFeilds()
    {
        return $this->merge([
            Images::make(__("Logo"), 'logo') 
                ->conversionOnPreview('icon') 
                ->conversionOnDetailView('thumbnail') 
                ->conversionOnIndexView('thumbnail'),

            Video::make(__("Video"), 'video') 
                ->conversionOnPreview('thumbnail') 
                ->conversionOnDetailView('thumbnail') 
                ->conversionOnIndexView('thumbnail')     
                ->hideFromIndex(),

            Images::make(__("Gallery"), 'gallery') 
                ->conversionOnPreview('main') 
                ->conversionOnDetailView('thumbnail') 
                ->conversionOnIndexView('thumbnail')    
                ->fullSize()
                ->stacked()
                ->hideFromIndex(),
        ]);
    } 

    public function seoFields()
    {
        return $this->translatable([
            Json::make('seo', [
                Text::make(__('Title'), 'title')->sortable(),
                Textarea::make(__('Description'), 'description')->sortable(),
            ]),
        ]);
    }

    public function relations()
    { 
        return [ 
            BelongsToMany::make(__("Food"), 'foods', Food::class)->fields(function(){  
                $meals = collect(Helper::days())->map(function($label, $day) {
                    return Multiselect::make(__($label), $day)
                                ->options(Helper::meals())
                                ->saveAsJSON();
                });

                return collect([
                    Boolean::make(__("Available"), 'available'),
                ])->merge($meals)->all(); 
            }),

            BelongsToMany::make(__("Service Range"), 'zones', Zone::class)
                ->fields(function() {
                    return [
                        Number::make(__("Duration"), 'duration')
                            ->rules(['required', 'min:0'])
                            ->default(0)
                            ->withMeta(['min' => 0])
                            ->help(__("Minute")),

                        $this->priceField(__("Cost"), 'cost'),

                        Textarea::make(__('Description'), 'description')    
                            ->rules('max:250'),
                    ];
                }),

            MorphedByMany::make(__("Categories"), 'categories', Category::class)
                ->fields(function($request){   
                    return [
                        Number::make(__("Order"), 'order')
                    ];
                }),

            // MorphedByMany::make(__("Facilities"), 'facilities', \Armincms\Facility\Nova\Facility::class)->fields(function($request){

            //     $field = data_get(
            //         Facility::find($request->relatedResourceId), 'type', Text::class
            //     );     

            //     return [$field::make(class_basename($field), 'value')];
            // })->withMeta(['conditionalPivotFields' => true]),
            
            BelongsToMany::make(__("Working Hours"), 'workingDays', WorkingDay::class)
                ->fields(new Fields\MealTimeFields),
        ];
    }
}
