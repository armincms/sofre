<?php

namespace Armincms\Sofre;
    

class RestaurantType extends Model 
{   
    protected $medias = [
        'image' => [ 
            'disk'  => 'armin.image',
            'schemas' => [
                'logo', 'icon', 'thumbnail'
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
