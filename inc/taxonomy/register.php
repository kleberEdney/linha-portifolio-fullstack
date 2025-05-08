<?php


function la_port_fullstack_taxonomy()
{
    $labels = array(
        'name' => _x('Tecnologias', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Tecnologia', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Buscar Tecnologias', 'textdomain'),
        'all_items' => __('Todas as Tecnologias', 'textdomain'),
        'parent_item' => __('Tecnologia Pai', 'textdomain'),
        'parent_item_colon' => __('Tecnologia Pai:', 'textdomain'),
        'edit_item' => __('Editar Tecnologia', 'textdomain'),
        'update_item' => __('Atualizar Tecnologia', 'textdomain'),
        'add_new_item' => __('Adicionar Nova Tecnologia', 'textdomain'),
        'new_item_name' => __('Nome da Nova Tecnologia', 'textdomain'),
        'menu_name' => __('Tecnologia', 'textdomain'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true,
    );
    register_taxonomy(LA_PORT_FULL_TAX, array(LA_PORT_FULL_CPT_DEV, LA_PORT_FULL_CPT_WEB), $args);
}
add_action('init', 'la_port_fullstack_taxonomy', 0);
