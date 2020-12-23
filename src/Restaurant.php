<?php
namespace Armincms\Sofre;  
   
use Laravelista\Comments\Commentable;  
use Cviebrock\EloquentSluggable\Sluggable;
use Core\HttpSite\Concerns\{IntractsWithSite, HasPermalink}; 
use Core\HttpSite\Component;  
use Armincms\Categorizable\Categorizable;
use Armincms\Taggable\Taggable;

class Restaurant extends Model 
{    
    use InteractsWithFood, InteractsWithDiscount, InteractsWithAreas, Branching, HasOpeningHours;
    use IntractsWithSite, HasPermalink, Sluggable, Commentable, Categorizable, Taggable; 

    const LOCALE_KEY = 'language';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'contacts' => 'json',
        'working_hours' => 'json',
        'sending_method' => 'json',
        'payment_method' => 'json',
    ];

    protected $medias = [
        'image' => [ 
            'disk'  => 'armin.image',
            'conversions' => [
                'restaurant', 'common'
            ]
        ], 

        'logo' => [ 
            'disk'  => 'armin.image',
            'conversions' => [
                'restaurant', 'common'
            ]
        ], 

        'video' => [ 
            'disk'  => 'armin.file', 
        ], 
    ]; 

    /**
     * The `RestaurantType` related model.
     *  
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(RestaurantType::class, 'restaurant_type_id');
    }

    /**
     * Driver name of the targomaan.
     * 
     * @return [type] [description]
     */
    public function translator(): string
    {
        return 'sequential';
    }

    public function component() : Component
    { 
        return new Components\Restaurant;
    } 

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ]; 
    }

    public function getUrl()
    {
        return app('site')->get('sofre')->url(urldecode($this->url));
    }
}
