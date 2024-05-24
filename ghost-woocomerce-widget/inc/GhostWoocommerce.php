<?php

namespace inc;

class GhostWoocommerce
{
    public function index(){
        $this->registerStyles();
        $this->registerScripts();
        ob_start();
        require_once PLUGIN_PATH.'/template/my_woocommerce_template.php';
        return ob_get_clean();
    }

    protected function registerStyles(){
        wp_enqueue_style('ghost_bootstrap_styles',PLUGIN_URL.'/assets/css/bootstrap.min.css');
        wp_enqueue_style('ghost_styles',PLUGIN_URL.'/assets/css/app.css');

    }

    protected function registerScripts(){
        wp_enqueue_script('ghost_bootstrap_script', PLUGIN_URL.'/assets/js/bootstrap.min.js',['jquery']);
        wp_enqueue_script('ghost_script', PLUGIN_URL.'/assets/js/app.js',['jquery']);
    }
}