<?php

namespace Armincms\Sofre\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\{ID, Text, Boolean, KeyValue, BelongsTo, MorphMany};  
use Armincms\NovaComment\Nova\Comment;
use Armincms\Fields\Targomaan;
use Armincms\Sofre\Helper;

class Menu extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Models\Menu::class; 

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'food'
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
        ]; 
    } 

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return false;
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->food->name;
    }


    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function pluralLabel()
    {
        return __('Food');
    }
}
