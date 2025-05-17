<?php


function la_port_fullstack_metabox_cpt($post)
{
    wp_nonce_field('salvar_metabox_cpt', 'metabox_cpt_nonce');
    $terms = get_terms([
        'taxonomy' =>  LA_PORT_FULL_TAX,
        'hide_empty' => false,
    ]);
    $term_used =  array();
    $term_used_obj =  wp_get_post_terms($post->ID, LA_PORT_FULL_TAX);

    foreach ($term_used_obj as $value) {
        $term_used[] = $value->term_id;
    }
?>
    <div>
        <?php foreach ($terms  as $value) : ?>
            <div style="display: flex; gap:0.7rem; align-items: center;">
                <?php
                $image = get_term_meta($value->term_id, LA_PORT_FULL_TAX . "-img", true);
                $checked =  in_array($value->term_id, $term_used) ? "checked" :  "";

                ?>
                <input type="checkbox" value="<?php echo $value->slug ?>" name="la-port-fulls-tx-post[]" <?php echo $checked ?>>
                <img src="<?php echo $image; ?>" alt="preview-gallery" id="tax-img" width="25" height="25" style="object-fit: cover">
                <label for=""><?php echo $value->name ?> </label>
            </div>
        <?php endforeach; ?>
    </div>

<?php
}
