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
}
