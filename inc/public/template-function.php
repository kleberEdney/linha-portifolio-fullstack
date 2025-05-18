<?php


function la_port_fulls_render_tecnolog($post_id, $size = 30)
{
    $term_list = get_the_terms($post_id, LA_PORT_FULL_TAX);
    $tax = LA_PORT_FULL_TAX . "-img";
    $onclick = "";
?>
    <?php foreach ($term_list as $term) : ?>
        <?php
        $image = get_term_meta($term->term_id, $tax, true);
        echo '<img src="' . $image . '" width="' . $size . '" height="' . $size . '"  title="' . $term->name . '" class="" style="object-fit: contain" ' .  $onclick . ' loading="lazy" />'
        ?>
    <?php endforeach; ?>

<?php
}



function la_port_fulls_render_slide($post_id, $modal = false)
{
    $img_json = get_post_meta($post_id, 'la_port_fulls_galeria_imgs', true);

    $last_element = end($img_json);
    $event =  "";

?>

    <?php if (!empty($img_json) && is_array($img_json)) : ?>
        <div id="la-port-fulls-img-<?php echo $post_id ?>" class="la-port-fulls-carousel-content">
            <?php echo la_port_fulls_render_carrousel_btn($img_json, 'prev') ?>

            <div class="la-port-fulls-carousel">
                <?php foreach ($img_json as $key => $value) : ?>
                    <?php
                    $pos_x =  $last_element === $value && count($img_json) > 1 ? -100 : 100 * $key;
                    if ($modal) {
                        $img_zoom =  wp_get_attachment_image_url($value, "full");
                        $event = 'onclick="window.open(\'' . $img_zoom . '\', \'_blank\'); return false"';
                    }
                    ?>
                    <img alt="Slides show imagem" style="left: <?php echo  $pos_x  ?>%" class="img-show" src='<?php echo wp_get_attachment_image_url($value, "medium_large") ?>' width="300" height="300" loading="lazy" <?php echo $event ?> />
                <?php endforeach; ?>
            </div>

            <?php echo la_port_fulls_render_carrousel_btn($img_json, 'next') ?>
        </div>
    <?php endif; ?>
<?php
}

function la_port_fulls_render_carrousel_btn($img_json, $side)
{
    ob_start();
?>
    <?php if (count($img_json) > 2): ?>
        <button aria-label="Botão de navegação" class="btn-<?php echo $side ?>" onclick="laPortFullSlideShow(this, '<?php echo $side ?>')">
            <img src="<?php echo LA_PORT_FULL_URL . "assets/media/next.svg" ?>" alt="<?php echo $side ?>" />
        </button>
    <?php endif; ?>

<?php
    return ob_get_clean();
}




function la_port_fulls_render($atts)
{
    la_port_fullstack_enqueue();
    $a = shortcode_atts(array(
        'type' => 'dev',
    ), $atts);

    $cpt =  $a['type'] == "dev" ?  LA_PORT_FULL_CPT_DEV : LA_PORT_FULL_CPT_WEB;
    $query_highlights = la_port_fulls_get_query_highlights($cpt);
    $query_normal = la_port_fulls_get_query_general($cpt);

    ob_start();
    require_once LA_PORT_FULL_PATH . "templates/public/render-list.php";
    return ob_get_clean();
}
add_shortcode('la_port_fulls', 'la_port_fulls_render');


function  la_port_fulls_get_query_highlights($cpt)
{
    $args = array(
        'post_type' => $cpt, // Seu custom post type
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => "AND",
            array(
                'key' => 'la_port_fulls_destaque',
                'compare' => '!=',
                'value'   => '',
            ),
            array(
                'key' => 'la_port_fulls_galeria_imgs',
                'compare' => '!=',
                'value'   => '',
            ),
        ),
    );

    return  new WP_Query($args);
}


function  la_port_fulls_get_query_general($cpt)
{
    $args = array(
        'post_type' => $cpt, // Seu custom post type
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'la_port_fulls_destaque', // Nome do meta key
                'compare' => 'NOT EXISTS', // Verifica se o meta key existe
                'value' => ''
            ),
        ),
    );

    return new WP_Query($args);
}
