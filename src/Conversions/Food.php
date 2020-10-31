<?php

namespace Armincms\Sofre\Conversions;

use Armincms\Conversion\Conversion; 

class Food extends Conversion
{ 
    /**
     * Get the registered schemas.
     * 
     * @return array
     */
    public function schemas()
    {
        return array_merge([ 
            'thumbnail' => [  
                'manipulations' => ['crop' => 'crop-center'], // resize type
                'width'         => 200,
                'height'        => 200, 
                'upsize'        => false, // cutting type
                'compress'      => 60,
                'extension'     => null, // save extension
                'placeholder'   => image_placeholder(200, 200),
                'label'         => __('Food Thumbnail Image'),
            ],

            'medium' => [  
                'manipulations' => ['crop' => 'crop-center'], // resize type
                'width'         => 650,
                'height'        => 650, 
                'upsize'        => false, // cutting type
                'compress'      => 60,
                'extension'     => null, // save extension
                'placeholder'   => image_placeholder(650, 650),
                'label'         => __('Food Medium Image'),
            ],
        ], parent::schemas());
    } 
}
