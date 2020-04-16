<?php

namespace Armincms\Sofre;

use Armincms\Models\Translation as Model;  

class Translation extends Model  
{   
    private static $sluggable = null;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'seo' => 'json',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        if($sluggable = static::$sluggable) { 
            return [
                'slug' => [
                    'source' => $sluggable
                ]
            ]; 
        }   

        return []; 
    } 

    public static function withSluggable(string $sluggable)
    {
        static::$sluggable = $sluggable;

        return new static;
    }
}