<?php
namespace Armincms\Sofre;  
 
use Spatie\OpeningHours\OpeningHours;   
use Armincms\Sofre\Helper;   

trait HasOpeningHours 
{   
    /**
     * Retrun opening hours.
     * 
     * @return \Spatie\OpeningHours\OpeningHours
     */
    public function workingHours()
    {
        return OpeningHours::create(Helper::modifyWorkingHours($this->working_hours));
    }

    /**
     * Determine if the restaurant is open at now.
     * 
     * @return boolean
     */
    public function isOpen()
    {
        return $this->workingHours()->isOpenAt(now(config('app.timezone')));
    } 

    /**
     * Returns the restaurant next opening time.
     * 
     * @return \DateTimeInterface
     */
    public function nextOpening()
    {
        return $this->workingHours()->nextOpen(now());
    }
}
