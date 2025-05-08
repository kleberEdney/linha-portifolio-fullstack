<?php

/**
 * Plugin Name: Linha Portfolio Fullstack.
 * Plugin URI: http://www.linhaartistica.com.br
 * Description: Gerenciador de Portfolio.
 * Version: 1.0
 * Author: Kleber Santos
 */

//require_once 'PageOption/Registros.php';
define("LA_PORT_FULL_CPT_DEV", 'la_port_fulls_dev');
define("LA_PORT_FULL_CPT_WEB", 'la_port_fulls_web');

define("LA_PORT_FULL_TAX", 'la_port_full_s_tax');
define("LA_PORT_FULL_URL", plugin_dir_url(__FILE__));
define("LA_PORT_FULL_PATH", plugin_dir_path(__FILE__));

$files = array(
    'equeue',
    'function',
    'ajax-web',

    'inc/cpt/dev/register',
    'inc/cpt/dev/metabox-upload',
    'inc/cpt/dev/save-upload',

    'inc/cpt/web/register',


    'inc/cpt/metabox-destaque',
    'inc/cpt/metabox-taxonomys',
    'inc/cpt/metabox-galery',
    'inc/cpt/save-gallery',
    'inc/cpt/save',
    'inc/cpt/gutemberg',

    'inc/taxonomy/metas',
    'inc/taxonomy/register',

    'inc/class/upload',
);

foreach ($files as $file) {
    require_once LA_PORT_FULL_PATH . $file . ".php";
}



add_action('init', 'my_custom_block');

function my_custom_block()
{
    // Register the block editor script
    $path = LA_PORT_FULL_PATH . "build/index.js";

    wp_register_script(
        'block-editor-js',
        $path,
        array(),
        filemtime($path)
    );

    // Register the block type
    register_block_type('linha-artistica/la_port_fullstack', array(
        'editor_script' => 'index',
    ));
}
