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
    'inc/equeue',
    // 'inc/function-template',
    'inc/ajax-web',

    "inc/public/template-function",
    "inc/admin/template-function",

    'inc/admin/cpt/dev/register',
    'inc/admin/cpt/dev/metabox-upload',
    'inc/admin/cpt/dev/save-upload',

    'inc/admin/cpt/web/register',


    'inc/admin/cpt/metabox-destaque',
    'inc/admin/cpt/metabox-taxonomys',
    'inc/admin/cpt/metabox-galery',
    'inc/admin/cpt/metabox-link',
    'inc/admin/cpt/save-gallery',
    'inc/admin/cpt/save',
    'inc/admin/cpt/gutemberg',

    'inc/admin/taxonomy/metas',
    'inc/admin/taxonomy/register',

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


add_filter('single_template', 'la_port_fulls_custom_template_function');
function la_port_fulls_custom_template_function($page_template)
{
    $id =  get_the_ID();
    $cpt = get_post_type($id);
    if ($cpt == LA_PORT_FULL_CPT_DEV || $cpt == LA_PORT_FULL_CPT_WEB) {
        $page_template = LA_PORT_FULL_PATH . 'templates/public/single-page.php';
    }
    return $page_template;
}
