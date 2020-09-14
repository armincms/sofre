<?php

namespace Armincms\Sofre\Nova;

use Illuminate\Http\Request; 
use Laravel\Nova\Fields\{ID, Text, HasMany}; 
use Armincms\Fields\Targomaan;

class Branch extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Branch::class;    

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
                    ->required()
                    ->rules('required'),
            ]), 

            $this->imageField(),

            $this->imageField('Logo', 'logo'),

            // HasMany::make(__("Restaurants"), 'restaurants', Restaurant::class),
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
