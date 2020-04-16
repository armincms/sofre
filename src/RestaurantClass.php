<?php

namespace Armincms\Sofre;
    

class RestaurantClass extends Model 
{ 

    protected $medias = [
        'logo' => [ 
            'disk'  => 'armin.image',
            'schemas' => [
                'logo', 'icon', 'thumbnail'
            ]
        ] 
    ]; 

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    /**
     * Get Translation model instance.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getTranslationModel()
    {
        return Translation::withSluggable('name');
    }
}
