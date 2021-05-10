<?php

use WPFluentFramework\Foundation\Application;
use WPFluentApp\Hooks\Handlers\ActivationHandler;
use WPFluentApp\Hooks\Handlers\DeactivationHandler;

return function($file) {

    register_activation_hook($file, function() {
        (new ActivationHandler)->handle();
    });

    register_deactivation_hook($file, function() {
        (new DeactivationHandler)->handle();
    });

    add_action('plugins_loaded', function() use ($file) {
        do_action('wpfluent_loaded', new Application($file));
    });
};
