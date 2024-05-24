<?php

namespace inc;

class Base
{
    public function __construct(){
        $this->Consts();
        $this->registerServices();
    }

    protected function Consts(){
        define("PLUGIN_PATH", dirname(plugin_dir_path(__FILE__)));
        define("PLUGIN_URL", dirname(plugin_dir_url(__FILE__)));
    }

    protected function registerServices(){
        require_once PLUGIN_PATH.'/inc/GhostWoocommerce.php';
    }


}