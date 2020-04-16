<?php

namespace Armincms\Sofre\Nova;

use Armincms\Nova\Resource as ArminResource;
use Laravel\Nova\Http\Requests\NovaRequest; 

abstract class Resource extends ArminResource
{   
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name'; 

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id'
    ];

    /**
     * The columns that should be searched in the translation table.
     *
     * @var array
     */
    public static $searchTranslations = [
        'name'
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Restaurant Services'; 
}
