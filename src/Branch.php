<?php
namespace Armincms\Sofre; 
       

class Branch extends Model 
{    
    protected $medias = [
        'logo' => [ 
            'disk'  => 'armin.image',
            'schemas' => [
                'logo', 'icon', 'thumbnail'
            ]
        ], 
        'image' => [ 
            'disk'  => 'armin.image',
            'schemas' => [
                'sofre.branche', '*'
            ]
        ]
    ]; 

    /**
     * The `restaurants` relationships
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }
}
