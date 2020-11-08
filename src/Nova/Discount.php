<?php

namespace Armincms\Sofre\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\{ID, Text, Select, Date, BooleanGroup, BelongsTo};   
use OwenMelbz\RadioField\RadioButton;
use Dpsoft\NovaPersianDate\PersianDateTime;
use Armincms\Fields\{InputSelect, Chain};

class Discount extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Discount::class; 

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'restaurant'
    ]; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {   
        return [
            ID::make()
                ->sortable()
                ->hideFromIndex((Boolean) request('viaResourceId')),

            BelongsTo::make(__('Restaurant'), 'restaurant', Restaurant::class)
                ->withoutTrashed()
                ->exceptOnForms(),

            Chain::as('restaurant-chain', function($request) {
                return [
                    Select::make(__('Restaurant'), 'restaurant_id')
                            ->options(Restaurant::newModel()->get()->pluck('name', 'id'))
                            ->required()
                            ->rules('required')
                            ->readonly($request->filled('viaResourceId'))
                            ->default($request->get('viaResourceId')),
                ];
            }),

            InputSelect::make(__('Discount'), 'discount')->options([
                    'amount' => static::currency() ?? __('Amount'),
                    'percent'=> __('%')
                ])
                ->input('value', 0.00)
                ->select('amount', 'amount') 
                ->displayUsingLabels()
                ->rules([function($attribute, $value, $fail) {
                    $value = json_decode($value, true); 

                    if($value['amount'] == 'percent' && $value['value'] > 100) {
                        $fail(__('Percent value should be less than 100.'));
                    } 
                }]),

            Text::make(__('Note'), 'note'),

            PersianDateTime::make(__('Starts At'), 'starts_at')
                ->required()
                ->rules('required'),

            PersianDateTime::make(__('Expires On'), 'expires_on')
                ->required()
                ->rules('required'), 

            Chain::as('menu', function() {
                return  [
                    RadioButton::make(__('Apply On'), 'apply', function() {
                            return $this->items ? 'food' : 'menu';
                        })
                        ->options([
                            'menu' => __('Menu'),
                            'food' => __('Food'),
                        ])
                        ->toggle([
                            'menu' => ['items']
                        ])
                        ->fillUsing(function($request, $model, $attribute, $requestAttribute) {
                            if($request->get('apply') == 'menu') {
                                $model->items = null;
                            }
                        }),
                ];
            }),

            Chain::with(['menu', 'restaurant-chain'], function($request) {
                if($request->filled('restaurant_id') && $request->get('apply') === 'food') {
                    $restaurant = Restaurant::newModel()->findOrFail($request->get('restaurant_id'));
                    $foods = $restaurant->foods()->get()->mapWithKeys(function($food) {
                        $key = (string) "{$food->id}";

                        return [
                            $key => "{$food->name} - ( {$food->pivot->price} " .static::currency(). ")",
                        ];
                    });

                    return [
                        BooleanGroup::make(__('Choose for discounting'), 'items')->options($foods->all()),
                    ]; 
                }
            }),            
        ]; 
    }

    public static function currency()
    {
        return data_get(Setting::currency(), 'symbol');
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [ 
        ];

    }
}
