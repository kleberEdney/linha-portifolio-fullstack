<?php


function la_port_fullstack_enqueue()
{
    $style_file = LA_PORT_FULL_URL . "assets/css/style-front.css";
    $scrits_file = LA_PORT_FULL_URL . "assets/js/script-front.js";
    $path = LA_PORT_FULL_PATH . "assets/js/script-front.js";

    wp_enqueue_style('la-port-fulls-style-fronts', $style_file);

    $version = filectime($path);

    wp_register_script('la_port_fulls_script', $scrits_file, array(), $version, 'all');
    wp_enqueue_script('la_port_fulls_script');

    wp_localize_script('la_port_fulls_script', 'la_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('la_nonce_ajax')
    ));
}



function la_port_fullstack_galeria_admin()
{
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    $style = LA_PORT_FULL_URL . 'assets/css/style-admin.css';
    $scrits = LA_PORT_FULL_URL . 'assets/js/script-adm-gallery.js';


    wp_register_script('galeria_script_admin', $scrits, array('jquery-ui-core'), '1.0.0', 'all');
    wp_enqueue_script('galeria_script_admin');

    wp_enqueue_style('galeria_style_admin', $style, array(), '1.0.0', 'all');
}
