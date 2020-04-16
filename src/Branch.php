<?php
namespace Armincms\Sofre; 
   
use Core\Crud\Contracts\SearchEngineOptimize as SEO;
use Core\Crud\Concerns\SearchEngineOptimizeTrait as SEOTrait;
use Core\HttpSite\Contracts\Linkable;  
use Core\HttpSite\Contracts\Hitsable;
use Core\HttpSite\Concerns\Visiting;
use Core\HttpSite\Concerns\IntractsWithSite;
use Core\HttpSite\Component;  

class Branch extends Model implements SEO, Linkable, Hitsable
{  
    use SEOTrait, Permalink, Visiting, IntractsWithSite;  

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['translations']; 
 
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
                'branche', '*'
            ]
        ]
    ];
 
    public function component() : Component
    {
        return new \Component\RestaurantServices\Components\RestaurantComponent;
    } 

    public function getTranslationModel()
    {
        return Translation::withSluggable('name');
    } 

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }
}
