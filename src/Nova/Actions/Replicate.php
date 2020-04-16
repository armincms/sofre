<?php

namespace Armincms\Sofre\Nova\Actions;
 
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;

class Replicate extends Action
{ 
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach($models as $model){
            $replicate = $model->replicate();
            $replicate->user()->associate(request()->user()); 
            $replicate->save();  
        }
    }
}
