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

    public function scopeAvailable($query)
    {
        return $query->whereStartsAt('>', (string) now())->whereExpiresOn('<', (string) now());
    }

    public function applyOn(Food $food)
    {
        $price = floatval(optional($food->pivot)->price);

        return $this->canApplyOn($food)? $this->applyDiscount($price) : $price;
    } 

    public function canApplyOn(Food $food)
    {
        return is_null($this->items) || collect((array) $this->items)->filter()->has($food->id);
    }

    public function applyDiscount(float $price)
    { 
        return $price - $this->discountAmount($price) ?: 0;
    }

    public function discountAmount(float $price)
    {
        return $this->isPercentage()
                    ? $this->getPercentageAmount($price, $this->discountValue()) 
                    : $this->discountValue();
    }

    public function isPercentage()
    {
        return data_get($this->discount, 'amount') === 'percent';
    }

    public function discountValue()
    {
        return floatval(data_get($this->discount, 'value'));
    }

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
