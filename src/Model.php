<?php
namespace Armincms\Sofre; 
  
use Illuminate\Database\Eloquent\Model as LaravelModel;  
use Armincms\Contracts\Authorizable;
use Armincms\Concerns\Authorization; 
use Armincms\Localization\Concerns\HasTranslation; 
use Armincms\Localization\Contracts\Translatable; 
use Illuminate\Database\Eloquent\SoftDeletes;
use Armincms\Concerns\IntractsWithMedia;
use Spatie\MediaLibrary\HasMedia\HasMedia;  

class Model extends LaravelModel implements Authorizable, Translatable, HasMedia
{   
    use Authorization, HasTranslation, SoftDeletes, IntractsWithMedia;
     
    protected $with = [
        'translations', 'user'
    ];    


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = [];  

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
     * Get Translation model instance.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getTranslationModel()
    {
        return Translation::withSluggable('name');
    }
}
