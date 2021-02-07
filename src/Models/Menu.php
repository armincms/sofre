<?php

namespace Armincms\Sofre\Models; 

use Armincms\Sofre\Helper; 
use Illuminate\Database\Eloquent\Relations\Pivot; 
use Laravelista\Comments\Commentable; 
use Armincms\Rating\Rateable; 
use Armincms\Orderable\Contracts\Saleable;
use Armincms\Sofre\Nova\Setting;

class Menu extends Pivot implements Saleable
{ 
    use Commentable, Rateable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; 

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'description' => '',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order'     => 'integer',
        'available' => 'boolean', 
    ];

    /**
     * Get the name attribute.
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        return optional($this->food)->name ?? '';
    }

    /**
     * Get the name attribute.
     * 
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return optional($this->food)->name ?? '';
    }
    
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return Helper::table(parent::getTable());
    } 

    /**
     * Query the related Food.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function food()
    {
        return $this->belongsTo(Food::class);
    } 

    /**
     * Query the related Restaurant.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    } 

    /**
     * Get the sale price of the item.
     * 
     * @return decimal
     */
    public function price()
    {
        return $this->salePrice(); 
    } 

    /**
     * Get the sale price currency.
     * 
     * @return decimal
     */
    public function currency(): string
    {
        return Setting::currencyCode();
    }

    /**
     * Get the sale price of the item.
     * 
     * @return decimal
     */
    public function salePrice(): float
    { 
        return $this->restaurant->discounts->filter->canApplyOn($this->food)->applyOn($this->price);
    }

    /**
     * Get the real price of the item.
     * 
     * @return decimal
     */
    public function oldPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the item name.
     * 
     * @return decimal
     */
    public function name(): string
    {
        return $this->food->name;
    }

    /**
     * Get the item description.
     * 
     * @return decimal
     */
    public function description(): string
    {
        return $this->name();
    }
}
