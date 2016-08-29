<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
            'Illuminate\Auth\Events\Login' => [
                    'App\Listeners\LoginSuccess',
            ],
            'Illuminate\Auth\Events\Logout' => [
                    'App\Listeners\LogoutSuccess',
            ],
            'App\Events\UserAccess' => [
                    'App\Listeners\UserAccess',
            ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
