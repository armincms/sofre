<?php
namespace Armincms\Sofre; 
  

class Food extends Model  
{   
    protected $medias = [
        'image' => [ 
            'disk'  => 'armin.image',
            'schemas' => [
                'food', 'food.list', '*'
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

    // /**
    //  * Get a relationship.
    //  *
    //  * @param  string  $key
    //  * @return mixed
    //  */
    // public function getRelationValue($key)
    // { 
    //     return in_array($key, ['price', 'discount']) ? null : parent::getRelationValue($key);
    // }   
    
    // public function restaurant()
    // {
    // 	return $this->belongsTo(Restaurant::class);
    // }   

    // public function restaurants()
    // {
    //     $pivotColumns = collect(Helper::days())->keys()->merge([
    //         'available', 'order', 'id'
    //     ]);

    //     return $this->belongsToMany(Restaurant::class, Helper::table('restaurant_food'))
    //                 ->withPivot($pivotColumns->all())
    //                 ->using(Menu::class);
    // }

    // public function discountPercent()
    // {
    //     if($this->oldPrice() == 0) return 0;
        
    //     return number_format(floatval($this->discount() / $this->oldPrice() * 100), 2);
    // }

    // public function oldPrice()
    // {
    //     return floatval($this->price);
    // }

    // public function price()
    // {
    //     return $this->oldPrice() - $this->discount();
    // } 

    // public function discount()
    // { 
    //     $value = array_get($this->discount, 'value');

    //     if('percent' === (int) array_get($this->discount, 'type')) {
    //         $value = $this->calcPricePercentage($value);
    //     }

    //     return floatval($value);
    // }

    // public function calcPricePercentage($percent)
    // {
    //    return (floatval($this->price) * $this->getValidPercent($percent)) / 100;
    // }

    // public function getValidPercent($percent)
    // {
    //     return (int) $percent > 99 ? 99 : intval($percent);
    // }    
}
