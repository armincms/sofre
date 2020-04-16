<?php
namespace Armincms\Sofre; 
  
use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model  
{  
    public $timestamps = false;

    public function restaurants()
    {
        $pivtes = collect(Helper::meals())->keys()->push('description')->all();

    	return $this
                ->belongsToMany(Restaurant::class, Helper::table('restaurant_working_day'))
                ->withPivot($pivtes)
                ->using(WorkingDayPivot::class); 	
    } 
    
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
