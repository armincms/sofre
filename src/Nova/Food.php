<?php

namespace Armincms\Sofre\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;  
use Laravel\Nova\Fields\KeyValue; 
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\ID;
use Armincms\Fields\{Targomaan, BelongsToMany};
use Armincms\Sofre\Helper;

class Food extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Food::class; 

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'group'
    ]; 

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
                ->sortable()
                ->hideFromIndex((Boolean) request('viaResourceId')),

            BelongsTo::make(__("Food Group"), 'group', FoodGroup::class)
                ->rules('required')
                ->sortable()
                ->withoutTrashed(), 

            new Targomaan([
                Text::make(__('Name'), 'name')
                    ->sortable()
                    ->required()
                    ->rules('required'),

                KeyValue::make(__('Material'), 'material')
                    ->hideFromIndex()
                    ->keyLabel(__("Material"))
                    ->actionText(__("Add Material")),
            ]),  

            $this->imageField(),
        ];
        // return collect([
        //     ID::make()
        //         ->sortable()
        //         ->hideFromIndex((Boolean) request('viaResourceId')),

        //     BelongsTo::make(__("Food Group"), 'group', FoodGroup::class)
        //         ->rules('required')
        //         ->sortable()
        //         ->withoutTrashed(), 

        //     new Targomaan([
        //         Text::make(__('Name'), 'name')
        //             ->sortable()
        //             ->required(),

        //         KeyValue::make(__('Material'), 'material')
        //             ->hideFromIndex()
        //             ->keyLabel(__("Material"))
        //             ->actionText(__("Add")),
        //     ]),   

        //     // BelongsToMany::make("Restaurants", 'restaurants', Restaurant::class)
        //     //     ->actions(function() {
        //     //         return [
        //     //             new Actions\Available,
        //     //             new Actions\Unavailable,
        //     //         ];
        //     //     })
        //     //     ->hideFromIndex(true),

        //     $this->imageField(), 

        // ])->merge($this->mealFields())->all();
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
            // (new Actions\Replicate)
            //     ->canRun(function() {
            //         return true;
            //     })
        ];

    }
}
