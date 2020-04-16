<?php
namespace Armincms\Sofre; 
  
use Illuminate\Database\Eloquent\Relations\Pivot;

class WorkingDayPivot extends Pivot  
{  
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	'breakfast' => 'json',
    	'dinner'    => 'json',
    	'evening'   => 'json',
    	'lunch'     => 'json',
    ]; 
    
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
