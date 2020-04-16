<?php

namespace Armincms\Sofre\Nova\Fields;

use Laravel\Nova\Fields\BelongsToMany as Field; 
use Laravel\Nova\Http\Requests\NovaRequest; 
use Armincms\Sofre\Nova\Rules\NotAttached; 

class Menu extends Field
{ 
    /**
     * Get the creation rules for this field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function getCreationRules(NovaRequest $request)
    { 
        $rules = parent::getCreationRules($request);

        $rules[$this->attribute] = collect($rules[$this->attribute])->reject(function($rule) {
            return $rule instanceof \Laravel\Nova\Rules\NotAttached;
        })->all();

        return array_merge_recursive($rules, [
            $this->attribute => [
                new NotAttached($request, $request->findModelOrFail()),
            ],
        ]);
    } 
}
