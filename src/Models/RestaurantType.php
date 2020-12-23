<?php

namespace Armincms\Sofre\Models;
    

class RestaurantType extends Model 
{   
    protected $medias = [
        'image' => [ 
            'disk'  => 'armin.image',
            'conversions' => [
                'restaurant-type', 'common'
            ]
        ], 
    ]; 

    /**
     * The `restaurants` relationship.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    } 
}
