<?php
namespace Armincms\Sofre\Models;  
 
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
        return OpeningHours::create(Helper::filterHours(Helper::modifyWorkingHours(
            $this->working_hours
        )));
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

    /**
     * Returns the restaurant next close time.
     * 
     * @return \DateTimeInterface
     */
    public function nextClosing()
    {
        return $this->workingHours()->nextClose(now());
    }
}
