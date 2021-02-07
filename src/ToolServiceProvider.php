<?php

namespace Armincms\Sofre;

use Laravel\Nova\Nova as LaravelNova; 
use Laravel\Nova\Events\ServingNova; 
use Illuminate\Support\Facades\Event; 
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
        Models\Order::class           =>  Policies\OrderPolicy::class, 
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
        $this->registerEventListeners();
        $this->registerObservers();
        $this->registerPolicies();
        $this->servingNova();  


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
            $blog->pushComponent(new Components\Category);
        });
    }

    public function registerEventListeners()
    {
        Event::listen(\NovaButton\Events\ButtonClick::class, Listeners\OrderSituation::class);
    }

    public function servingNova()
    {
        LaravelNova::resources([ 
            Nova\Restaurant::class,
            Nova\FoodGroup::class, 
            Nova\Menu::class,
            Nova\Food::class,
            Nova\Order::class,
            Nova\Category::class,
            Nova\Discount::class,
            Nova\RestaurantType::class,  
            Nova\Setting::class, 
        ]);   
    } 

    public function registerObservers()
    {
        Models\Order::observe(Observers\OrderObserver::class);
    }
}
