<?php

namespace Armincms\Sofre\Nova\Rules;

use Laravel\Nova\Rules\NotAttached as Rule; 

class NotAttached extends Rule
{  
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {  
        return ! in_array(
            $this->request->input($this->request->relatedResource),
            $this
                ->model
                ->{$this->request->viaRelationship}()
                ->withoutGlobalScopes()
                ->wherePivot('day', $this->request->day)
                ->wherePivot('meal', $this->request->meal)
                ->get()->modelKeys()
        );
    }  
}
