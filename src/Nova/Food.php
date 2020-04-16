<?php

namespace Armincms\Sofre\Nova;
 
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;
use Armincms\Sofre\Helper;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\KeyValue; 
use Laravel\Nova\Fields\BelongsTo; 
use Laravel\Nova\Fields\BelongsToMany;  
use Armincms\Nova\Fields\Images;

class Food extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\Sofre\Food'; 

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'restaurant', 'group'
    ];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ]; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {   
        return collect([
            ID::make()
                ->sortable()
                ->hideFromIndex((Boolean) request('viaResourceId')),

            BelongsTo::make(__("Food Group"), 'group', FoodGroup::class)
                ->rules('required')
                ->sortable()
                ->withoutTrashed(),

            BelongsTo::make(__("Restaurant"), 'restaurant', Restaurant::class)
                ->nullable()
                ->hideFromIndex()
                ->withoutTrashed(),

            $this->translatable([
                Text::make(__('Name'), 'name')
                    ->sortable()
                    ->required(),

                KeyValue::make(__('Material'), 'material')
                    ->hideFromIndex()
                    ->keyLabel(__("Material"))
                    ->actionText(__("Add")),
            ])->withToolbar(), 

            Number::make(__("Preparation Time"), "duration")
                ->rules("required", "min:0")
                ->required()
                ->default(0)
                ->help(__("Duration Of Making Food At Minute"))
                ->withMeta([
                    'min' => 0
                ])->displayUsing(function($value) {
                    return $value . PHP_EOL . __("Minute");
                })
                ->hideFromIndex((Boolean) request('viaResourceId')),

            $this->priceField() 
                ->onlyOnForms()
                ->help(currency()->getCurrency('IRR')['symbol']), 

            // Select::make(__("Currency"), "currency")->options(
            //     collect(currency()->getActiveCurrencies())->map->symbol
            // )->rules('required')->default('IRR')->onlyOnForms(),

            $this->priceField()
                ->hideFromIndex((Boolean) request('viaResourceId')),
 
            $this->discountField(),  

            BelongsToMany::make("Restaurants", 'restaurants', Restaurant::class)
                ->actions(function() {
                    return [
                        new Actions\Available,
                        new Actions\Unavailable,
                    ];
                })
                ->hideFromIndex(true),

            Images::make(__("Image"), 'image')
                ->conversionOnPreview('main') 
                ->conversionOnDetailView('thumbnail') 
                ->conversionOnIndexView('icon')
                ->fullSize(),

            Boolean::make(__("Available"), 'pivot->available') 
                ->onlyOnIndex()
                ->showOnIndex((boolean) request('viaResourceId'))

        ])->merge($this->mealFields())->all();
    }

    public function mealFields()
    {
        return collect(Helper::days())->map(function($label, $day) {
            return Text::make(__($label), function($resource) use ($day) {
                $restaurant = $resource
                                ->restaurants
                                ->where('id', request('viaResourceId'))
                                ->first(); 

                $value = collect($restaurant->pivot->{$day})->map(function($meal, $key) {
                    return __(title_case($meal)). ($key%2? '<br />' : ', ');
                })->implode('');

                return trim($value, ', ');
            })->onlyOnIndex()->showOnIndex((boolean) request('viaResourceId'))->asHtml();
        });
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new Actions\Replicate)
                ->canRun(function() {
                    return true;
                })
        ];

    }
}
