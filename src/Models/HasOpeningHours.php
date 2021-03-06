<?php
namespace Armincms\Sofre\Models;  

use Illuminate\Support\Str;
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
    public function openingTime()
    {
        return $this->isOpen() 
                    ? $this->workingHours()->previousOpen(now(config('app.timezone')))
                    : $this->workingHours()->nextOpen(now(config('app.timezone')));
    }

    /**
     * Returns the restaurant next close time.
     * 
     * @return \DateTimeInterface
     */
    public function closingTime()
    {
        return ! $this->isOpen() 
                    ? $this->workingHours()->previousClose(now(config('app.timezone')))
                    : $this->workingHours()->nextClose(now(config('app.timezone'))); 
    }

    /**
     * Get the today working hours.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function todayWorkingHours()
    { 
        return $this->workingHours()->forDay(Str::lower(now(config('app.timezone'))->format('l')));
    }
}
