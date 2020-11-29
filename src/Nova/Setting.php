<?php

namespace Armincms\Sofre\Nova;
  
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Select;
use Armincms\Nova\ConfigResource;  
use Armincms\Fields\OpeningHours;
use Armincms\Sofre\Helper;

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
            Select::make(__("Currency"), '_sofre_currency_')
                ->options(collect(currency()->getActiveCurrencies())->map->symbol->all())
                ->default("IRR")
                ->required()
                ->rules('required')
                ->withMeta(["value" => "IRT"])
                ->displayUsing(function($value, $resource, $attribute) {
                    return currency()->getCurrency($value)['symbol'];
                }), 

            Boolean::make(__("Online Reservation"), "_sofre_online_reserve_") 
                ->withMeta(["value" => true]),

            OpeningHours::make(__('Opening Hours'), '_sofre_opening_hours_')
                ->restrictTo(Helper::meals())
                ->withMeta([
                    'value' => static::openingHours(),
                ]),
        ];
    } 

    public static function currency()
    {
        $currencies = collect(currency()->getActiveCurrencies());
        $currency = static::option('_sofre_currency_', 'IRR');

        return $currencies->has($currency) ? $currencies->get($currency) : $currencies->first();
    }

    public static function openingHours()
    {
        return static::option(
            '_sofre_opening_hours_', Helper::fillWeekMeals()->map->values()->toArray()
        );
    }
}
