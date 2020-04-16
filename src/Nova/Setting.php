<?php

namespace Armincms\Sofre\Nova;
  
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Select;
use Armincms\Nova\ConfigResource;  

class Setting extends ConfigResource
{      

    /**
     * Get the store tag name.
     *
     * @return string
     */
    public static function storeTag() : string
    { 
        return 'sofre';
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __("Restaurant Services");
    } 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {   
        return [  
            Select::make(__("Currency"), '_sfore_currency_')
                ->options(collect(currency()->getActiveCurrencies())->map->symbol->all())
                ->default("IRR")
                ->required()
                ->rules('required')
                ->withMeta(["value" => "IRT"])
                ->displayUsing(function($value, $resource, $attribute) {
                    return currency()->getCurrency($value)['symbol'];
                }), 

            Boolean::make(__("Online Reservation"), "_sfore_online_reserve_") 
                ->withMeta(["value" => true])
        ];
    } 
}
