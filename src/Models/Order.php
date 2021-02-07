<?php

namespace Armincms\Sofre\Models;  

use Illuminate\Database\Eloquent\{Model , SoftDeletes};
use Armincms\Orderable\Concerns\InteractsWithInvoice;
use Zareismail\NovaPolicy\Contracts\Ownable;  
use Armincms\Contracts\Authorizable;
use Armincms\Concerns\Authorization;  
use Armincms\Sofre\Helper;  

class Order extends Model implements Authorizable, Ownable 
{    
    use SoftDeletes, Authorization, InteractsWithInvoice, Markables\OrderSituation; 

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function($model) {
            $model->fillOrderNumber();
        }); 
    }

    /**
     * Ensure the "number" column has filled.
     * 
     * @return $this
     */
    public function ensureOrderNumber()
    { 
        $this->hasVliadOrderNumber() || $this->fillOrderNumber();

        return $this;
    }

    /**
     * Determin if has a valid order numebr.
     * 
     * @return boolean
     */
    public function hasVliadOrderNumber()
    {
        return intval($this->number) !== 0 && 
               static::anothers()->todayOrders()->where('number', $this->number)->count() === 0;
    }

    /**
     * Fill the "number" column vai unique value.
     *  
     * @return integer
     */
    public function fillOrderNumber()
    {
        while (! $this->hasVliadOrderNumber()) 
            $this->forceFill(['number' => $this->generateOrderNumber()]); 
 
        return $this;
    }

    /**
     * Generate new order number per day.
     * 
     * @return integer
     */
    public function generateOrderNumber()
    {
        return intval(static::anothers()->todayOrders()->max('number')) + 1;
    }

    /**
     * Query only tpday created models.
     * 
     * @param  \Illuminate\Database\Eloqeunt\Builder $query 
     * @return \Illuminate\Database\Eloqeunt\Builder        
     */
    public function scopeTodayOrders($query)
    {
        return $query->whereDate('created_at', (string) now());
    }

    /**
     * Query except curent model.
     * 
     * @param  \Illuminate\Database\Eloqeunt\Builder $query 
     * @return \Illuminate\Database\Eloqeunt\Builder        
     */
    public function scopeAnothers($query)
    {
        return $query->where($this->getKeyName(), '!=', $this->getKey());
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
     * Indicate Model Authenticatable.
     * 
     * @return mixed
     */
    public function owner()
    {
        return $this->user();
    } 
}
