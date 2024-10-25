<?php

namespace App\Providers;

use App\Services\Contracts\IContractService;
use App\Services\Contracts\IPdfService;
use App\Services\Contracts\IRefundService;
use App\Services\Contracts\IVoucherService;
use App\Services\Contracts\IVouherExportService;
use App\Services\ContractService;
use App\Services\PdfService;
use App\Services\RefundService;
use App\Services\VoucherExportService;
use App\Services\VoucherService;
use Illuminate\Support\Facades\URL;
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
        $this->app->bind(abstract: IVouherExportService::class, concrete: VoucherExportService::class);
        $this->app->bind(abstract: IContractService::class, concrete: ContractService::class);
        $this->app->bind(abstract: IRefundService::class, concrete: RefundService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
