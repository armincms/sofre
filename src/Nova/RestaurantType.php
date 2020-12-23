<?php

namespace Armincms\Sofre\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\{ID, Text}; 
use Armincms\Fields\Targomaan;

class RestaurantType extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Models\RestaurantType::class; 

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
                    ->rules('required')
            ]),

            $this->imageField()
                    ->conversionOnPreview('common-thumbnail') 
                    ->conversionOnDetailView('common-thumbnail') 
                    ->conversionOnIndexView('common-thumbnail'),
        ];
    } 
}
