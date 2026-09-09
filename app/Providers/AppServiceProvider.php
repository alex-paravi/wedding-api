<?php

namespace App\Providers;

use App\Contracts\NotificationSenderInterface;
use App\Services\TelegramNotificationSender;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Говорим Laravel: когда просят контракт, давай реализацию Email
        $this->app->bind(NotificationSenderInterface::class, TelegramNotificationSender::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
