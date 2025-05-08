<?php


function la_port_fullstack_disable_gutenberg($can_edit, $post_type)
{
    $list = array(LA_PORT_FULL_CPT_WEB, LA_PORT_FULL_CPT_DEV);

    if (in_array($post_type, $list)) {
        return false;
    }
    return $can_edit;
}
add_filter('use_block_editor_for_post_type', 'la_port_fullstack_disable_gutenberg', 10, 2);
