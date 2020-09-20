<?php

namespace Armincms\Sofre\Nova\Fields;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Boolean; 
use OptimistDigital\MultiselectField\Multiselect; 
use Armincms\Sofre\Helper; 

class Menu 
{ 
    public function __invoke()
    { 
        return Collection::make(Helper::days())
                ->map([$this, 'meals'])
                ->prepend(Boolean::make(__("Available"), 'available'))
                ->all();
    }

    public function meals($label, $day)
    { 
        return  Multiselect::make(__($label), $day)
                    ->options(Helper::meals())
                    ->saveAsJSON()
                    ->resolveUsing(function($value) {
                        return explode(',', $value);
                    }); 
    }
}
