<?php
namespace Armincms\Sofre\Models; 
  
use Illuminate\Database\Eloquent\{Model as LaravelModel, SoftDeletes}; 
use Spatie\MediaLibrary\HasMedia\HasMedia;  
use Armincms\Targomaan\Concerns\InteractsWithTargomaan; 
use Armincms\Targomaan\Contracts\Translatable;  
use Armincms\Concerns\HasMediaTrait; 
use Armincms\Contracts\{Authorizable, HasLayout};
use Armincms\Concerns\{Authorization, InteractsWithLayouts}; 
use Zareismail\NovaPolicy\Contracts\Ownable; 
use Armincms\Sofre\Helper;

class Model extends LaravelModel implements Authorizable, Translatable, HasMedia, Ownable, HasLayout
{   
    use Authorization, InteractsWithTargomaan, SoftDeletes, HasMediaTrait, InteractsWithLayouts; 

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'json',
    ];
    
    /**
     * The related medias.
     *
     * @var array
     */
    protected $medias = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return Helper::table(parent::getTable());
    }  

    /**
     * Indicate Model Authenticatable.
     * 
     * @return mixed
     */
    public function owner()
    {
        return $this->user();
    }

    /**
     * Get feature images for the given converions
     * 
     * @param  array $conversions 
     * @param  string $name        
     * @return array              
     */
    public function featuredImages($conversions, $name = 'image')
    {
        return $this->getConversions($this->getFirstMedia($name), (array) $conversions);
    }

    /**
     * Get feature image for the given converion
     * 
     * @param  array $conversions 
     * @param  string $name        
     * @return array              
     */
    public function featuredImage(string $conversion, $name = 'image')
    {
        return $this->featuredImages((array) $conversion, $name)->get($conversion);
    }
}
