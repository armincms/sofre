<?php

namespace Armincms\Sofre\Models; 

use Armincms\Sofre\Helper; 
use Illuminate\Database\Eloquent\Relations\Pivot; 

class Menu extends Pivot
{ 
    public $timestamps = false; 
    public static $ordering = false;

    protected $casts = [
        'order'     => 'integer',
        'available' => 'boolean', 
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

    public function setOrderAttribute($order)
    {     
        $this->attributes['order'] = (int) $order; 
    }

    public static function boot()
    {
        parent::boot(); 
 
        static::saved([static::class, 'reorder']);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public static function reorder($model)
    {
        return;
        $order = 0;

        if(static::$ordering) return;
 
        static::$ordering = true;  

        static::where('order', '>=', $order)->where('id', '!=', $model->id)->increment('order');

        $orderer = function($menu) use (&$order) {
            $menu->order = $order++;  

            $menu->save();
        };

        static::where('restaurant_id', $model->restaurant_id)->orderBy('order')->get()->each($orderer);   

        static::$ordering = false;
    }
}
