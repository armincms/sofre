<?php

namespace Armincms\Sofre\Nova;

use Illuminate\Http\Request; 
use Laravel\Nova\Fields\{ID, Text, HasMany}; 
use Armincms\Fields\Targomaan;

class FoodGroup extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Models\FoodGroup::class;    

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            new Targomaan([
                Text::make(__('Name'), 'name')  
                    ->sortable()
                    ->required(), 
            ]),

            HasMany::make(__('Foods'), 'foods', Food::class),
        ];
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
}
