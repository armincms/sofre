<?php

namespace Armincms\Sofre\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\{ID, Text, Boolean, KeyValue, BelongsTo, MorphMany};  
use Armincms\NovaComment\Nova\Comment;
use Armincms\Fields\Targomaan;
use Armincms\Sofre\Helper;

class Food extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Models\Food::class; 

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

            Boolean::make(__('Private'), 'private')
                ->default(false),

            BelongsTo::make(__("Food Group"), 'group', FoodGroup::class)
                ->showCreateRelationButton()
                ->withoutTrashed()
                ->sortable()
                ->rules('required'), 

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

            $this->imageField()
                    ->conversionOnPreview('food-thumbnail') 
                    ->conversionOnDetailView('food-thumbnail') 
                    ->conversionOnIndexView('food-thumbnail'),

            MorphMany::make(__('Comments'), 'comments', Comment::class), 
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
