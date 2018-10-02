<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AuditableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('auditable', function($createdByFieldName = 'created_by', $updatedByFieldName = 'updated_by') {
            $this->unsignedInteger($createdByFieldName)->nullable()->index();
            $this->unsignedInteger($updatedByFieldName)->nullable()->index();
        });

        Blueprint::macro('dropAuditable', function($createdByFieldName = 'created_by', $updatedByFieldName = 'updated_by') {
            $this->dropColumn([$createdByFieldName, $updatedByFieldName]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
