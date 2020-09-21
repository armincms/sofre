<?php 

namespace Armincms\Sofre;
use Illuminate\Support\Str;

class Helper
{ 
    public static function table(string $table)
    {
        $prefix = "sofre_";

        return (Str::startsWith($table, $prefix) ? '' : $prefix).$table;
    }

    public static function branching()
    {
        return [
            'independent' => __('Independent'),
            'branch'    => __('Branch'),
            'chained'   => __('Chained'),
        ]; 
    }

    public static function sendingMethod()
    {
        return [
            'serve'     => __('Serve'),
            'delivery'  => __('Delivery At Restaurant'),
            'courier'   => __('Courier'),
        ];
    }

    public static function paymentMethods()
    {
        return [
            'pos'      => __('POS'),
            'online'   => __('Online'),
            'cash'     => __('Cash'),
            'credit'   => __('Credit'),
        ];
    }

    public static function days()
    {
        return [
            'saturday'  => __('Saturday'), 
            'sunday'    => __('Sunday'), 
            'monday'    => __('Monday'), 
            'tuesday'   => __('Tuesday'), 
            'wednesday' => __('Wednesday'), 
            'thursday'  => __('Thursday'), 
            'friday'    => __('Friday')
        ];
    }

    public static function meals()
    {
        return [
            'breakfast' => __('Breakfast'), 
            'lunch'     => __('Lunch'), 
            'evening'   => __('Evening'), 
            'dinner'    => __('Dinner'),
        ]; 
    }


    public static function defaultMealDuration(string $meal) { 
        switch ($meal) {
            case 'breakfast':
                return [
                    'from'  => '05:00',
                    'until' => '08:00',
                ];
                break;
            case 'lunch':
                return [
                    'from'  => '11:00',
                    'until' => '15:00',
                ];
                break;
            case 'evening':
                return [
                    'from'  => '15:00',
                    'until' => '19:00',
                ];
                break;
            case 'dinner':
                return [
                    'from'  => '19:00',
                    'until' => '24:00',
                ];
                break;
            
            default:
                return [
                    'from'  => '05:00',
                    'until' => '24:00',
                ];
                break;
        } 
    }  

    public static function fillWeekMeals(callable $callback)
    {
        return collect(Helper::days())->map(function($day, $name) use ($callback) {  
            return static::fillMeals($callback, $name);
        });
    }

    public static function fillMeals(callable $callback, $day)
    {
        return collect(Helper::meals())->map(function($meal, $name) use ($callback, $day) { 
            return $callback($name, $day) ?: static::defaultMealDuration($name); 
        }); 
    }
}