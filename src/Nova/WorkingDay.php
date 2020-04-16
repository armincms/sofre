<?php

namespace Armincms\Sofre\Nova;
 
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;  
use Illuminate\Support\Str;  
use Laravel\Nova\Fields\BelongsToMany; 
use Armincms\Sofre\Helper; 

class WorkingDay extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\Sofre\WorkingDay';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'day';

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = ['restaurants'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Indicates if the resoruce should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 7;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $meals = collect(Helper::meals())->map(function($label, $meal) {
            return Text::make(__($label), function($resource) use ($meal) {
                $restaurant = $resource->restaurants->where('id', request('viaResourceId'))->first();
                if($restaurant) {
                    $duration = $restaurant->pivot->{$meal};  

                    return ($duration['from'] ?? '-') ." - ". ($duration['until'] ?? '-');
                }
            })->onlyOnIndex();
        });

        return collect([
            ID::make()->sortable(),

            Text::make(__("Day"), 'day')
                ->rules('requried')
                ->displayUsing(function($day) {
                    return __(title_case($day));
                }), 

            BelongsToMany::make(__("Restaurants"), 'restaurants', Restaurant::class)
                ->actions(function() {
                    return [
                        new Actions\UpdateTime
                    ];
                })
                
        ])->merge($meals)->all();
    } 
 
    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return __(Str::title($this->{static::$title}));
    } 

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'workingDays';
    }
}
