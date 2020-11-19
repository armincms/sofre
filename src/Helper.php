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


    public static function guessMealTime($meal)
    {
        switch ($meal) {
            case 'breakfast':
                return '06:00-10:00';
                break;

            case 'lunch':
                return '11:30-14:30';
                break;

            case 'evening':
                return '16:00-18:00';
                break;

            case 'dinner':
                return '19:00-23:00';
                break;
            
            default:
                return '00:08-23:00';
                break;
        }
    }

    public static function fillWeekMeals(callable $callback = null)
    {
        return collect(Helper::days())->map(function($day, $name) use ($callback) {  
            return static::fillMeals($name, $callback = null);
        });
    }

    public static function fillMeals($day, callable $callback = null)
    {
        return collect(Helper::meals())->map(function($meal, $data) use ($callback, $day) { 
            $hours = is_callable($callback) ? $callback($data, $day) : static::guessMealTime($data); 

            return compact('hours', 'data');
        }); 
    }
}