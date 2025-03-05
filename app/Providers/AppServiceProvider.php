<?php

namespace App\Providers;

use App\Models\Unit;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Formulations;
use App\Models\Processe;
use App\Models\Company;
use App\Observers\UserObserver;
use App\Observers\SupplierObserver;
use App\Observers\ProcessObserver;
use App\Observers\CompanyObserver;
use App\Observers\UnitObserver;
use App\Observers\FormulationObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Supplier::observe(SupplierObserver::class);
        Unit::observe(UnitObserver::class);
        Formulations::observe(FormulationObserver::class);
        Processe::observe(ProcessObserver::class);
        Company::observe(CompanyObserver::class);



    }
}
