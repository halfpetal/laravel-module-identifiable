<?php

namespace Halfpetal\Laravel\Identifiable;

use Illuminate\Support\ServiceProvider;

class IdentifiableServiceProdiver extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if(!class_exists('CreateIdentifiersTable')) {
            // Publish the migrations
            $stub      = __DIR__ . '/database/migrations/';
            $target    = database_path('migrations') . '/';
            $this->publishes([
                $stub . 'create_identifiers_table.php' => $target . date('Y_m_d_His', time()) . '_create_identifiers_table.php'
            ], 'migrations');
        }
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
}
