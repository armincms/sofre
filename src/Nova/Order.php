<?php

namespace Armincms\Sofre\Nova;
 
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\{ID, Badge, Text, Number, Select, BelongsTo};   
use NovaButton\Button;
use Armincms\Nova\User;
use Armincms\Sofre\Helper;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Sofre\Models\Order::class; 

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'invoice'
    ]; 

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'number'
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
            ID::make()->sortable(),

            Number::make(__('Number'), 'number')
                ->sortable(), 

            BelongsTo::make(__("Customer"), 'user', User::class) 
                ->exceptOnForms(), 

            BelongsTo::make(__("Invoice"), 'invoice', config('orderable.resources.invoice')) 
                ->exceptOnForms(), 

            Badge::make(__('Status'), 'marked_as')->map([
                    'pending'   => 'danger',
                    'onhold'    => 'warning',
                    'preparing' => 'info',
                    'shipped'   => 'info', 
                    'completed' => 'success',
                ]),

            Select::make(__('Sending Method'), 'sending_method')
                ->options(Helper::sendingMethod())
                ->displayUsingLabels(),

            Select::make(__('Payment Method'), 'payment_method')
                ->options(Helper::paymentMethods())
                ->displayUsingLabels(), 

            $this->merge(function() { 
                $label = 'Preparing';
                $key = 'order-preparing';

                if($this->isPreparing()) {
                    $label = 'Shipped';
                    $key = 'order-shipped';
                }

                if($this->isShipped()) {
                    $label = 'Completed';
                    $key = 'order-completed';
                }
                 
                return [ 
                    Button::make(__($label), $key) 
                        ->style('primary-outline')
                        ->reload()
                        ->visible(! $this->isPending() && ! $this->isCompleted())
                ];
            }),
        ]; 
    } 
}
