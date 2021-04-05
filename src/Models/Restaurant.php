<?php
namespace Armincms\Sofre\Models;  
   
use Laravelista\Comments\Commentable;  
use Cviebrock\EloquentSluggable\Sluggable;
use Core\HttpSite\Concerns\{IntractsWithSite, HasPermalink}; 
use Core\HttpSite\Component;  
use Armincms\Taggable\Contracts\Taggable;
use Armincms\Orderable\Contracts\Orderable;
use Armincms\Taggable\Concerns\InteractsWithTags;
use Armincms\Categorizable\Concerns\InteractsWithCategories; 

class Restaurant extends Model implements Taggable, Orderable
{    
    use InteractsWithFood, InteractsWithDiscount, InteractsWithAreas, Branching, HasOpeningHours;
    use IntractsWithSite, HasPermalink, Sluggable, Commentable, InteractsWithCategories, InteractsWithTags; 

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
     * Query the related categories.
     * 
     * @return \Illuminate\Database\Eloqenut\Relations\BelongsToMany
     */
    public function categories() 
    {
        return $this->morphToMany(Category::class, 'categorizable', 'categorizable');
    } 

    /**
     * Query the related food.
     * 
     * @return \Illuminate\Database\Eloqenut\Relations\BelongsToMany
     */
    public function saleables()
    {
        return $this->menus();
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
        return new \Armincms\Sofre\Components\Restaurant;
    } 

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
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
