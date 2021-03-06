<?php

namespace Armincms\Sofre\Nova\Fields;
 
use Laravel\Nova\Fields\{Text, Number};  
use Armincms\Nova\Fields\Money; 
use Armincms\Sofre\Nova\Setting;; 

class Areas
{ 
    public function __invoke()
    { 
        
        return [
            Number::make(__("Duration"), 'duration')
                ->rules(['required', 'min:0'])
                ->default(0)
                ->withMeta(['min' => 0])
                ->help(__("Minute")),
 
            Money::make(__("Cost"), 'cost')
                ->currency(Setting::currencyCode())
                ->default(0.00),

            Text::make(__('Note'), 'note')    
                ->rules('max:250'),
        ];
    } 
}
