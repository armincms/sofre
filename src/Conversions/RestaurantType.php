<?php

namespace Armincms\Sofre\Conversions;

use Armincms\Conversion\Conversion; 

class RestaurantType extends Conversion
{ 
    /**
     * Get the registered schemas.
     * 
     * @return array
     */
    public function schemas()
    {
        return array_merge([ 
            'logo' => [  
                'manipulations' => ['crop' => 'crop-center'], // resize type
                'width'         => 311,
                'height'        => 233, 
                'upsize'        => false, // cutting type
                'compress'      => 60,
                'extension'     => null, // save extension
                'placeholder'   => image_placeholder(311, 233),
                'label'         => __('Restaurant Type Image'),
            ], 
        ], parent::schemas());
    } 
}
