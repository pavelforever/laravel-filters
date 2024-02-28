<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PostService;


class PostServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(PostService::class,function(){
            return new PostService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
