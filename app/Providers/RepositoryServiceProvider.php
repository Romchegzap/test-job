<?php

namespace App\Providers;

use App\Interfaces\SubmissionRepositoryInterface;
use App\Repositories\SubmissionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SubmissionRepositoryInterface::class, SubmissionRepository::class);
    }
}
