<?php

namespace Armincms\Sofre\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Number; 
use Laravel\Nova\Http\Requests\NovaRequest;
use Armincms\Nova\Fields\Images;

class RestaurantClass extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\Sofre\RestaurantClass'; 

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
            
            $this->abstracts(),

            $this->imageField('logo', __("Logo")),
        ];
    } 
}
