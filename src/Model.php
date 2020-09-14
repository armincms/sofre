<?php
namespace Armincms\Sofre; 
  
use Illuminate\Database\Eloquent\{Model as LaravelModel, SoftDeletes}; 
use Spatie\MediaLibrary\HasMedia\HasMedia;  
use Armincms\Targomaan\Concerns\InteractsWithTargomaan; 
use Armincms\Targomaan\Contracts\Translatable;  
use Armincms\Concerns\IntractsWithMedia; 
use Armincms\Contracts\Authorizable;
use Armincms\Concerns\Authorization; 

class Model extends LaravelModel implements Authorizable, Translatable, HasMedia
{   
    use Authorization, InteractsWithTargomaan, SoftDeletes, IntractsWithMedia; 

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
}
