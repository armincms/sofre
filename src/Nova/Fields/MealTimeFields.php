<?php 

namespace Armincms\Sofre\Nova\Fields;

use Laraning\NovaTimeField\TimeField; 
use Laravel\Nova\Fields\Heading;  
use Armincms\Sofre\Helper;
use Armincms\Json\Json; 


class MealTimeFields
{
    /**
     * Get the pivot fields for the relationship.
     *
     * @return array
     */
    public function __invoke()
    {
        return collect(Helper::meals())->map([$this, 'mealFields'])->flatten()->all();
    }

    public function mealFields($meal, $name)
    {
        return [
            Heading::make(__($meal)),

            Json::make($name, [
                TimeField::make(__("From"), 'from', [$this, 'resolveCallback'])
                    ->rules('required')
                    ->fillUsing([$this, 'fillCallback']),

                TimeField::make(__("Until"), 'until', [$this, 'resolveCallback'])
                    ->rules('required')
                    ->fillUsing([$this, 'fillCallback']),  
            ]),
        ];
    }

    public function resolveCallback($value, $resource, $attribute)
    {
        if(! empty($value) && $this->validated($value)) {
            return \Carbon\Carbon::createFromFormat('H:i', $value)->format('H:i'); 
        }
    }

    public function fillCallback($request, $attribute, $requestAttribute)
    {
        list($meal, $duration) = explode('->', $attribute);

        $sentData = array_get(Helper::defaultMealDuration($meal), $duration);

        if ($request->exists($requestAttribute)) {
            $sentData = $request[$requestAttribute];
        } 

        if (! $this->validated($sentData)) {
            throw new \Exception('The field must contain a valid time.');
        }

        return \Carbon\Carbon::createFromFormat("H:i", $sentData)->format('H:i'); 
    }

    public function validated($time)
    {
        return \DateTime::createFromFormat("H:i", $time) !== false;
    }
} 