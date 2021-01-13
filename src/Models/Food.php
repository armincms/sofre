<?php

namespace Armincms\Sofre\Models; 
  
use Laravelista\Comments\Commentable; 

class Food extends Model  
{   
    use Commentable;
    
    protected $medias = [
        'image' => [ 
            'disk'  => 'armin.image',
            'conversions' => [
                'food'
            ]
        ], 
    ]; 
    
    /**
     * The `group` relationship.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(FoodGroup::class, 'food_group_id');
    } 

    /**
     * Query the related Restaurant`s.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class)
                    ->using(Menu::class);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new FoodCollection($models);
    }

    /**
     * Get the food price.
     * 
     * @return 
     */
    public function price()
    {
        return floatval($this->pivot->price);
    }
}
