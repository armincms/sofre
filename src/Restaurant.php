<?php
namespace Armincms\Sofre; 
     

class Restaurant extends Model 
{  
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'contacts' => 'json',
    ];

    protected $medias = [
        'gallery' => [ 
            'disk'  => 'armin.image',
            'schemas' => [
                'food', 'food.list', '*'
            ]
        ], 

        'logo' => [ 
            'disk'  => 'armin.image',
            'schemas' => [
                'icon', 'logo', 'thumbnail'
            ]
        ], 

        'video' => [ 
            'disk'  => 'armin.file', 
        ], 
    ]; 

    /**
     * Driver name of the targomaan.
     * 
     * @return [type] [description]
     */
    public function translator(): string
    {
        return 'sequential';
    }
}
