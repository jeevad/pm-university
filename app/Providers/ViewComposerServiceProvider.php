<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composerTopics();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Composer the topics.
     */
    private function composerTopics()
    {
        view()->composer('partials.topics._bachelore', 'App\Http\ViewComposers\TopicsComposer@bachelore');
        view()->composer('partials.topics._master', 'App\Http\ViewComposers\TopicsComposer@master');
    }
}
