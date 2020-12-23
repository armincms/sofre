<?php

namespace Armincms\Sofre;

use Laravel\Nova\Nova as LaravelNova; 
use Laravel\Nova\Events\ServingNova; 
use Illuminate\Support\ServiceProvider; 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;


class ToolServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [ 
        Models\Food::class           =>  Policies\FoodPolicy::class, 
        Models\Discount::class       =>  Policies\RestaurantDiscount::class, 
        Models\FoodGroup::class      =>  Policies\FoodGroupPolicy::class,    
        Models\Restaurant::class     =>  Policies\RestaurantPolicy::class, 
        Models\RestaurantType::class =>  Policies\RestaurantTypePolicy::class, 
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sofre');
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang'); 
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->configureWebComponents();
        $this->registerPolicies();
        LaravelNova::serving([$this, 'servingNova']); 


        $this->app->resolving('conversion', function($conversion) { 
            $conversion->extend('restaurant', function() {
                return new Conversions\Restaurant;
            });
            $conversion->extend('restaurant-type', function() {
                return new Conversions\RestaurantType;
            });
            $conversion->extend('food', function() {
                return new Conversions\Food;
            });
        });
    } 

    public function configureWebComponents()
    { 
        \Site::push('sofre', function($blog) {
            $blog->directory('sofre');
 
            $blog->pushComponent(new Components\SearchRestaurant);
            $blog->pushComponent(new Components\Restaurant);
        });
    }

    public function servingNova(ServingNova $event)
    {
        LaravelNova::resources([ 
            Nova\Restaurant::class,
            Nova\FoodGroup::class, 
            Nova\Food::class,
            Nova\Category::class,
            Nova\Discount::class,
            Nova\RestaurantType::class,  
            Nova\Setting::class, 
        ]);   
    } 
}
