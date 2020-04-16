<?php

namespace Armincms\Sofre; 

use Armincms\Localization\Translation as Model;

class FoodTranslation extends Model  
{    

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'discount' => 'json',
        'material' => 'json',
    ]; 
}