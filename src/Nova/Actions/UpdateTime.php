<?php

namespace Armincms\Sofre\Nova\Actions;
 
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use Armincms\Sofre\Nova\Fields\MealTimeFields; 
use Illuminate\Http\Resources\MergeValue; 
use Armincms\Sofre\Helper;

class UpdateTime extends Action
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
        foreach ($models as $model) {
            $callback = function($meal, $column) use ($fields, $model) {  
                return collect($model->{$column})->merge(
                    collect($fields->get($column))->filter()->all()
                );   
            };

            $data = collect(Helper::meals())->map($callback)->filter()->toArray();

            $model->update($data); 
        } 
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return collect((new MealTimeFields)->__invoke())->map(function($field) {
            return $field instanceof MergeValue ? $field->data : [$field];
        })->flatten()->map(function($field) {
            return method_exists($field, 'rules') ? $field->rules([]) : $field; 
        })->all();
    }
}
