<?php

function la_port_fullstack_post_type_layout()
{
	$labels = array(
		'name' => _x('Portifolio Dev', 'Post Type General Name', 'text_domain'),
		'singular_name' => _x('Portifolio Dev', 'Post Type Singular Name', 'text_domain'),
		'menu_name' => __('Portifolio Dev', 'text_domain'),
		'name_admin_bar' => __('Portifolio Dev', 'text_domain'),
		'archives' => __('Portifolio Dev', 'text_domain'),
		'attributes' => __('Portifolio Dev', 'text_domain'),
		'parent_item_colon' => __('Parent Item:', 'text_domain'),
		'all_items' => __('Todas Portifolio Devs', 'text_domain'),
		'add_new_item' => __('Novo Portifolio Dev', 'text_domain'),
		'add_new' => __('adicionar Portifolio Dev', 'text_domain'),
		'new_item' => __('Novo Portifolio Dev', 'text_domain'),
		'edit_item' => __('Editar Portifolio Dev', 'text_domain'),
		'update_item' => __('Atualizar Portifolio Dev', 'text_domain'),
		'view_item' => __('ver Portifolio Dev', 'text_domain'),
		'view_items' => __('ver Portifolio Devs', 'text_domain'),
		'search_items' => __('Procura Portifolio Devs', 'text_domain'),
		'not_found' => __('não encontrado', 'text_domain'),
		'not_found_in_trash' => __('não encontrado no lixo', 'text_domain'),
		'featured_image' => __('imagem destaque', 'text_domain'),
		'set_featured_image' => __('set imagem destaque', 'text_domain'),
		'remove_featured_image' => __('remover imagem destaque', 'text_domain'),
		'use_featured_image' => __('usar imagem de destaque', 'text_domain'),
		'insert_into_item' => __('Insert into item', 'text_domain'),
		'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
		'items_list' => __('Items list', 'text_domain'),
		'items_list_navigation' => __('Items list navigation', 'text_domain'),
		'filter_items_list' => __('Filter items list', 'text_domain'),
	);
	$args = array(
		'label' => __('Portifolio Dev', 'text_domain'),
		'description' => __('Informação da Portifolio Dev', 'text_domain'),
		'labels' => $labels,
		'supports' => array('title', 'thumbnail', 'editor'),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'page',
		'show_in_rest' => true,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'template_lock' => 'all'

	);
	register_post_type(LA_PORT_FULL_CPT_DEV, $args);
}
add_action('init', 'la_port_fullstack_post_type_layout', 0);


// Adiciona a metabox
function la_port_fulls_addmetabox_cpt_dev()
{
	add_meta_box(LA_PORT_FULL_TAX . "-id", 'Tecnologia', 'la_port_fullstack_metabox_cpt', LA_PORT_FULL_CPT_DEV, 'side');
	add_meta_box(LA_PORT_FULL_CPT_DEV . "-destaque", 'Destaque', 'la_port_fullstack_destaque', LA_PORT_FULL_CPT_DEV, 'side');
	add_meta_box(LA_PORT_FULL_CPT_DEV . "-iframe", 'Iframe', 'portfolio_zip_metabox_html', LA_PORT_FULL_CPT_DEV, 'side');
	add_meta_box(LA_PORT_FULL_CPT_DEV . '-galery', 'Galeria', 'la_port_fulls_render_galeria', LA_PORT_FULL_CPT_DEV, 'normal', 'high');
}
add_action('add_meta_boxes', 'la_port_fulls_addmetabox_cpt_dev');
