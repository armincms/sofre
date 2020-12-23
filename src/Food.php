<?php

namespace Armincms\Sofre; 
  
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
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new FoodCollection($models);
    }
}
