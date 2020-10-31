<?php

namespace Armincms\Sofre\Conversions;

use Armincms\Conversion\Conversion; 

class Restaurant extends Conversion
{ 
    /**
     * Get the registered schemas.
     * 
     * @return array
     */
    public function schemas()
    {
        return array_merge([ 
            'mobile' => [  
                'manipulations' => ['crop' => 'crop-center'], // resize type
                'width'         => 480,
                'height'        => 320, 
                'upsize'        => false, // cutting type
                'compress'      => 60,
                'extension'     => null, // save extension
                'placeholder'   => image_placeholder(480, 320),
                'label'         => __('Restaurant Mobile Image'),
            ],

            'logo' => [  
                'manipulations' => ['crop' => 'crop-center'], // resize type
                'width'         => 150,
                'height'        => 150, 
                'upsize'        => false, // cutting type
                'compress'      => 60,
                'extension'     => null, // save extension
                'placeholder'   => image_placeholder(480, 320),
                'label'         => __('Restaurant Logo Image'),
            ],
        ], parent::schemas());
    } 
}
