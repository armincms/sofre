<?php

namespace Armincms\Sofre\Models\Markables;
  

trait HasPreparing
{    
    /**
     * Mark the model with the "preparing" value.
     *
     * @return $this
     */
    public function asPreparing()
    {
        return $this->markAs($this->getPreparingValue());
    } 

    /**
     * Determine if the value of the model's "marked as" attribute is equal to the "preparing" value.
     * 
     * @param  string $value 
     * @return bool       
     */
    public function isPreparing()
    {
        return $this->markedAs($this->getPreparingValue());
    }

    /**
     * Query the model's `marked as` attribute with the "preparing" value.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query  
     * @return \Illuminate\Database\Eloquent\Builder       
     */
    public function scopePreparing($query)
    {
        return $this->mark($this->getPreparingValue());
    }

    /**
     * Set the value of the "marked as" attribute as "preparing" value.
     * 
     * @return $this
     */
    public function setPreparing()
    {
        return $this->setMarkedAs($this->getPreparingValue());
    }

    /**
     * Get the value of the "preparing" mark.
     *
     * @return string
     */
    public function getPreparingValue()
    {
        return defined('static::PREPARING_VALUE') ? static::PREPARING_VALUE : 'preparing';
    }
}
