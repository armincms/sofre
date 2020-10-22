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
        Food::class           =>  Policies\FoodPolicy::class, 
        FoodGroup::class      =>  Policies\FoodGroupPolicy::class,    
        Restaurant::class     =>  Policies\RestaurantPolicy::class, 
        RestaurantType::class =>  Policies\RestaurantTypePolicy::class, 
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
    } 

    public function configureWebComponents()
    { 
        \Site::push('sofre', function($blog) {
            $blog->directory('sofre');
 
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
            Nova\RestaurantType::class,  
            // Nova\Setting::class, 
        ]);   
    } 
}
