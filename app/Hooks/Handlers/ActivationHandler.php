<?php

namespace WPFluentApp\Hooks\Handlers;

use WPFluentApp\Database\DBMigrator;
use WPFluentApp\Database\DBSeeder;

class ActivationHandler
{
    public function handle($network_wide = false)
    {
        DBMigrator::run($network_wide);
        DBSeeder::run();
    }
}
