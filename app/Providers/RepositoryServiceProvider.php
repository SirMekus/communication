<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\MessageRepositoryInterface;
use App\Repositories\TelegramRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageRepositoryInterface::class, TelegramRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
