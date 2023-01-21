<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\TollGate\Models\Transaction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Transaction::observe(\Modules\TollGate\Observers\TransactionObserver::class);
    }
}
