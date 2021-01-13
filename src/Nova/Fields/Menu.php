<?php

namespace Armincms\Sofre\Nova\Fields;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\{Number, Boolean}; 
use OptimistDigital\MultiselectField\Multiselect; 
use Armincms\Sofre\Helper; 
use Armincms\Nova\Fields\Money;
use Armincms\Sofre\Nova\Setting;

class Menu 
{ 
    public function __invoke()
    { 
        return Collection::make(Helper::days())
                ->map([$this, 'meals'])
                ->prepend($this->priceField())
                // ->prepend(Number::make(__('Order'), 'order')->required()->rules('required'))
                ->prepend(Number::make(__('Duration'), 'duration')->required()->rules('required'))
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

    public function priceField()
    {
        return Money::make(__('Price'), 'price')
                    ->default(0.00)
                    ->currency(Setting::currencyCode()); 
    }
}
