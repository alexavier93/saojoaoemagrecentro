<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Treatment;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('*', function($view){
            $lastOrders = Order::all()->take(3);
            $view->with('lastOrders', $lastOrders);
        });

        view()->composer('*', function($view){
            $treatments = Treatment::all();
            $view->with('menuTreatments', $treatments);
        });

        view()->composer('*', function($view){
            $categories = Category::all();
            $view->with('menuCategories', $categories);
        });


        view()->composer('*', function($view){

            $cart = session()->get('cart');

            if (session()->exists('cart')) {

                $sum = 0;
                foreach($cart['products'] as $key => $value)
                {
                    $sum+= $value['qty'];
                }

                $view->with('cartSum', $sum);

            }

            
        });

        view()->composer('*', function($view){
            
            if (session()->exists('customer')) {

                $customer = session()->get('customer');

            }else{

                $customer = null;
            }

            $view->with('CUSTOMER_SESSION', $customer);

        });

    }
}
