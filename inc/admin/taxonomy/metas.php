<?php



// Adiciona um campo de imagem na taxonomia
function la_port_fullstack_add_image_field_to_taxonomy($taxonomy)
{
?>
    <div class="form-field term-group">
        <label for="<?= LA_PORT_FULL_TAX ?>_image"><?php _e('Imagem', 'textdomain'); ?></label>
        <input type="text" id="<?= LA_PORT_FULL_TAX ?>_image" name="<?= LA_PORT_FULL_TAX ?>_image" value="" />
        <input type="button" class="button" value="<?php _e('Upload Image', 'textdomain'); ?>" />
    </div>
<?php
}
add_action(LA_PORT_FULL_TAX . "_add_form_fields", 'la_port_fullstack_add_image_field_to_taxonomy', 10, 2);

// Edita o campo de imagem na taxonomia
function la_port_fullstack_edit_image_field_in_taxonomy($term, $taxonomy)
{
    $tax = LA_PORT_FULL_TAX . "-img";
    $image = get_term_meta($term->term_id, $tax, true);
?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="<?= $tax ?>"><?php _e('Imagem', 'textdomain'); ?></label></th>
        <td>
            <img src="<?php echo esc_attr($image); ?>" alt="image-tax" id="tax-img" width="100" height="100"
                style="object-fit: cover">
            <input type="text" id="tax-img-input" name="<?php echo $tax ?>" value="<?php echo esc_attr($image); ?>" />
            <input type="button" onclick="laPortifolioStakMetaMedias(event)" class="button" value="Upload Image" />
        </td>
    </tr>
<?php
}
add_action(LA_PORT_FULL_TAX . '_edit_form_fields', 'la_port_fullstack_edit_image_field_in_taxonomy', 10, 2);

// Salva o campo de imagem na taxonomia
function la_port_fullstack_save_taxonomy_image($term_id)
{
    if (isset($_POST[LA_PORT_FULL_TAX . '-img'])) {
        update_term_meta($term_id, LA_PORT_FULL_TAX . '-img', esc_url($_POST[LA_PORT_FULL_TAX . '-img']));
    }
}
add_action('edited_term', 'la_port_fullstack_save_taxonomy_image');
// add_action('created_' . LA_PORT_FULL_TAX, '_save_taxonomy_image', 10, 2);
// add_action('edited_' . LA_PORT_FULL_TAX, '_save_taxonomy_image', 10, 2);

// Adiciona scripts e estilos para o upload da imagem
function la_port_fullstack_enqueue_media_uploader()
{
    wp_enqueue_media();
    wp_enqueue_script(LA_PORT_FULL_TAX . '_image_upload', LA_PORT_FULL_URL . 'assets/js/script-adm.js', array(), null, true);
}
add_action('admin_enqueue_scripts', 'la_port_fullstack_enqueue_media_uploader');
