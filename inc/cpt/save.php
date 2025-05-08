<?php

function la_port_fulls_save_custom_taxonomy_meta($post_id)
{

    // Verifica se o usuário tem permissão para salvar.
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Verifica se é um autosave.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }


    // dprint($_POST, true);
    // Obtém o valor da metabox.
    $new_value = isset($_POST['la-port-fulls-tx-post']) ? $_POST['la-port-fulls-tx-post'] : '';

    // Salva o valor como uma taxonomia personalizada.
    if (!empty($new_value)) {
        wp_set_post_terms($post_id, $new_value, LA_PORT_FULL_TAX);
    }

    if (isset($_POST['la_port_fulls_destaque'])) {
        $value = sanitize_text_field($_POST['la_port_fulls_destaque']);
        update_post_meta($post_id, 'la_port_fulls_destaque', $value);
    } else {
        delete_post_meta($post_id, 'la_port_fulls_destaque');
    }
}
add_action('save_post_' .  LA_PORT_FULL_CPT_DEV, 'la_port_fulls_save_custom_taxonomy_meta');
add_action('save_post_' .  LA_PORT_FULL_CPT_WEB, 'la_port_fulls_save_custom_taxonomy_meta');
