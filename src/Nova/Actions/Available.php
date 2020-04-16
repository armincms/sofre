<?php

namespace Armincms\Sofre\Nova\Actions;
 
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Boolean;

class Available extends Action
{ 
    protected $available = 1;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    { 
        if($model = $models->first()) { 
            $model
                ->where($model->qualifyColumn('restaurant_id'), $model->restaurant_id)
                ->whereIn($model->qualifyColumn('food_id'), $models->map->food_id->all())
                ->update(['available' => $this->available]); 
        }
    }  
}
