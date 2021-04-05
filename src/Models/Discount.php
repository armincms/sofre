<?php

namespace Armincms\Sofre\Models;  

use Illuminate\Database\Eloquent\{Model, SoftDeletes}; 
use Armincms\Concerns\Authorization; 
use Armincms\Contracts\Authorizable;
use Zareismail\NovaPolicy\Contracts\Ownable; 
use Armincms\Sofre\Helper;

class Discount extends Model implements Authorizable, Ownable
{     
    use SoftDeletes, Authorization;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'array',
        'discount' => 'array',
        'starts_at' => 'datetime',
        'expires_on' => 'datetime',
    ];

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
     * The `restaurant` relationship.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }  

    /**
     * Indicate Model Authenticatable.
     * 
     * @return mixed
     */
    public function owner()
    {
        return $this->user();
    }

    /**
     * Query unexpired discounts.
     * 
     * @param  \Illuminate\Database\Eloqeunt\Builder $query 
     * @return \Illuminate\Database\Eloqeunt\Builder $query       
     */
    public function scopeAvailable($query)
    {
        return $query->whereStartsAt('<', (string) now())->whereExpiresOn('<', (string) now());
    }

    /**
     * Apply the discount on the given food.
     * 
     * @param  mixed   $food 
     * @return float       
     */
    public function applyOn(Food $food)
    {
        $price = floatval(optional($food->pivot)->price);

        return $this->canApplyOn($food)? $this->applyDiscount($price) : $price;
    }  

    /**
     * Determine if discount can apply on a given food.
     * 
     * @param  mixed   $food 
     * @return boolean       
     */
    public function canApplyOn(Food $food): bool
    { 
        if (! $this->isAvailable()) {
            return false;
        }

        return is_null($this->items) || collect((array) $this->items)->filter()->has($food->id);
    }

    /**
     * Determine if discount is available.
     * 
     * @return boolean 
     */
    public function isAvailable(): bool
    {
        return $this->started() && ! $this->expired();
    } 

    /**
     * Determine if discount is started.
     * 
     * @return boolean 
     */
    public function started(): bool
    { 
        return $this->starts_at->lte(now());
    } 

    /**
     * Determine if discount is out of date.
     * 
     * @return boolean 
     */
    public function expired(): bool
    {  
        return $this->expires_on->lt(now());
    } 

    /**
     * Apply discount to the given price.
     * 
     * @return boolean 
     */
    public function applyDiscount(float $price)
    { 
        return $price - $this->discountAmount($price) ?: 0;
    } 

    /**
     * Calculate amount of discount.
     * 
     * @return boolean 
     */
    public function discountAmount(float $price)
    {
        return $this->isPercentage()
                    ? $this->getPercentageAmount($price, $this->discountValue()) 
                    : $this->discountValue();
    } 

    /**
     * Determin if discount is type of percentage.
     * 
     * @return boolean 
     */
    public function isPercentage(): bool
    {
        return data_get($this->discount, 'amount') === 'percent';
    } 

    /**
     * Get the raw value of the discount.
     * 
     * @return boolean 
     */
    public function discountValue()
    {
        return floatval(data_get($this->discount, 'value'));
    } 

    /**
     * Calculate value of a given percent.
     *
     * @param  $price
     * @param  $percent
     * @return boolean 
     */
    public function getPercentageAmount(float $price, float $percent)
    {
        return ($price * $percent) / 100;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new DiscountCollection($models);
    }
}
