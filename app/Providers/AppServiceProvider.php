<?php

namespace App\Providers;

use App\Services\Contracts\IPdfService;
use App\Services\Contracts\IVoucherService;
use App\Services\PdfService;
use App\Services\VoucherService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: IVoucherService::class, concrete: VoucherService::class);
        $this->app->bind(abstract: IPdfService::class, concrete: PdfService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
