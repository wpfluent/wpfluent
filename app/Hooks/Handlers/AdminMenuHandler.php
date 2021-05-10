<?php

namespace WPFluentApp\Hooks\Handlers;

use WPFluentApp\App;

class AdminMenuHandler
{
    public function add()
    {
        $capability = 'manage_options';

        add_menu_page(
            __('wpfluent_plugin_name', 'wpfluent_plugin_textDomain'),
            __('wpfluent_plugin_name', 'wpfluent_plugin_textDomain'),
            $capability,
            'wpfluent_plugin_slug',
            [$this, 'render'],
            $this->getMenuIcon(),
            6
        );
    }

    public function render()
    {
        $this->enqueueAssets();

        $config = App::getInstance('config');

        $name = $config->get('app.name');

        $slug = $config->get('app.slug');

        App::make('view')->render('admin.menu', compact('name', 'slug'));
    }

    public function enqueueAssets()
    {
        $app = App::getInstance();

        $assets = $app['url.assets'];

        $slug = $app->config->get('app.slug');

        wp_enqueue_script(
            $slug . '_admin_app_boot',
            $assets . '/admin/js/boot.js',
            ['jquery']
        );

        wp_enqueue_style(
            $slug . '_admin_app', $assets . '/admin/css/admin.css'
        );

        wp_localize_script($slug . '_admin_app_boot', $slug, [
            'slug'  => $slug = $app->config->get('app.slug'),
            'nonce' => wp_create_nonce($slug),
            'rest'  => $this->getRestInfo($app),
            'brand_logo' => $this->getMenuIcon(),
            'asset_url' => $assets
        ]);

        do_action($slug . '_loading_app');

        wp_enqueue_script(
            $slug . '_admin_app_start',
            $assets . '/admin/js/start.js',
            array($slug . '_admin_app_boot'),
            '1.0',
            true
        );

        wp_enqueue_script(
            $slug . '_admin_app_vendor',
            $assets . '/admin/js/vendor.js',
            [$slug . '_admin_app_start'],
            '1.0',
            true
        );
    }

    protected function getRestInfo($app)
    {
        $ns = $app->config->get('app.rest_namespace');
        $ver = $app->config->get('app.rest_version');

        return [
            'base_url'  => esc_url_raw(rest_url()),
            'url'       => rest_url($ns . '/' . $ver),
            'nonce'     => wp_create_nonce('wp_rest'),
            'namespace' => $ns,
            'version'   => $ver
        ];
    }

    protected function getMenuIcon()
    {
        return 'dashicons-wordpress-alt';
    }
}
