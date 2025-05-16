<?php

function la_port_fulls_galeria_grid_save_metas()
{
        $post_id = get_the_ID();
        $list = array(
                'la_port_fulls_galeria_imgs',
        );

        foreach ($list as $value) {
                $valor = isset($_POST[$value]) ? $_POST[$value] : '';
                update_post_meta($post_id, $value, $valor);
        }
}

add_action('save_post_' . LA_PORT_FULL_CPT_DEV, 'la_port_fulls_galeria_grid_save_metas');
add_action('save_post_' . LA_PORT_FULL_CPT_WEB, 'la_port_fulls_galeria_grid_save_metas');
