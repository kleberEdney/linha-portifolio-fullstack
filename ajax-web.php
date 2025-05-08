<?php

function la_port_fulls_ajax()
{
    //check_ajax_referer('la_nonce_ajax', 'nonce');
    $test = true;

    if (isset($_POST['post']) && isset($_POST['type'])) {
        $post = sanitize_text_field($_POST['post']);
        $resposta = la_port_fulls_render_post($post);
        wp_send_json_success($resposta);
    } else {
        wp_send_json_error('Nenhum dado recebido.');
    }
}
add_action('wp_ajax_la_port_fulls_ajax', 'la_port_fulls_ajax');
add_action('wp_ajax_nopriv_la_port_fulls_ajax', 'la_port_fulls_ajax');

function la_port_fulls_ajax_iframe()
{
    check_ajax_referer('la_nonce_ajax', 'nonce');

    if (isset($_POST['post'])) {
        $post = sanitize_text_field($_POST['post']);
        $resposta = la_port_fulls_render_iframe($post);
        wp_send_json_success($resposta);
    } else {
        wp_send_json_error('Nenhum dado recebido.');
    }
}
add_action('wp_ajax_la_port_fulls_ajax_iframe', 'la_port_fulls_ajax_iframe');
add_action('wp_ajax_nopriv_la_port_fulls_ajax_iframe', 'la_port_fulls_ajax_iframe');
