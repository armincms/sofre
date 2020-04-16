<?php

namespace Armincms\Sofre; 


trait WorkingHours
{  
    static public function days()
    {
        return [
            'saturday'  => 'Saturday', 
            'sunday'    => 'Sunday', 
            'monday'    => 'Monday', 
            'tuesday'   => 'Tuesday', 
            'wednesday' => 'Wednesday', 
            'thursday'  => 'Thursday', 
            'friday'    => 'Friday'
        ];
    }

    static public function meals()
    {
        return [
            'Breakfast', 'Lunch', 'Evening', 'Dinner' 
        ]; 
    } 
    
    public function workingHours()
    { 
        return collect(static::days())->map(function($day) {

            $meals = collect(static::meals())->map(function($meal) use ($day) {
                return [
                    'meal' => __($meal),
                    'duration' => $this->mealDuration($meal, $day),
                ];
            });

            return [
                'day' => __($day),
                'meals' => $meals,
            ];
        });
    }

    public function mealDuration(string $meal, string $day)
    {
        return [
            'from'  => $this->mealStartTime($meal, $day),
            'until' => $this->mealEndTime($meal, $day),
        ];
    }

    public function mealStartTime(string $meal, string $day)
    {
        return $this->mealTime($meal, $day, 'start');
    } 

    public function mealEndTime(string $meal, string $day)
    {
        return $this->mealTime($meal, $day, 'end');
    }

    protected function mealTime(string $day, string $meal, string $time)
    {
        $hour = $this->mealHour($day, $meal, $time);
        $minute = $this->mealMinute($day, $meal, $time);

        if(empty($hour) && empty($minute)) {
            return null;
        }

        return $this->stringTime($hour, $minute);
    } 

    public function mealHour($day, $meal, $time = 'start')
    {  
        return $this->mealTimeData($day, $meal, "{$time}_hour");
    }

    public function mealMinute($day, $meal, $time = 'start')
    {
        return $this->mealTimeData($day, $meal, "{$time}_minute");
    }

    public function mealTimeData(string $meal, string $day, string $time)
    {
        $every = data_get($this->working_hours, strtolower("everyday_{$meal}_{$time}"));
        $day = data_get($this->working_hours, strtolower("{$day}_{$meal}_{$time}")); 

        return preg_replace('/[^0-9]+/', '', $day) ?: preg_replace('/[^0-9]+/', '', $every);
    }

    public function stringTime(string $hour, string $minute)
    {
        return sprintf('%02s : %02s', (int) $hour, (int) $minute);
    }
}