<?php
function la_port_fulls_render($atts)
{
    $a = shortcode_atts(array(
        'type' => 'dev',
    ), $atts);

    $cpt =  $a['type'] == "dev" ?  LA_PORT_FULL_CPT_DEV : LA_PORT_FULL_CPT_WEB;

    la_port_fullstack_enqueue();

    $args_destaques = array(
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

    $query_destaque = new WP_Query($args_destaques);

    $args_normal = array(
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

    $query_normal = new WP_Query($args_normal);



    ob_start();
?>
    <div class="la-fulls-content">
        <?php if ($query_destaque->have_posts()) : ?>
            <div class="la-fulls-grid-highlight-content">
                <?php while ($query_destaque->have_posts()) : $query_destaque->the_post();  ?>
                    <?php
                    $post_id =  get_the_ID();
                    ?>
                    <div>
                        <div class="la-card">
                            <div class="la-card-body">
                                <div class="la-img">
                                    <?php echo la_port_fulls_render_slide($post_id) ?>
                                    <div onclick="laFullsShowJob('<?php echo $post_id ?>', '<?php echo $a['type'] ?>')" class="la-port-fulls-carousel-action"></div>
                                </div>
                                <?php the_title('<h3>', '</h3>'); ?>
                                <?php the_excerpt() ?>

                            </div>
                            <div class="la-card-footer">
                                <div style="display: flex; flex-wrap: wrap; ; margin-top: 1rem; justify-content: center; gap: 1rem">
                                    <?php echo la_port_fulls_render_tecnolog($post_id) ?>
                                </div>
                                <div>
                                    <button class="la-btn" onclick="laFullsShowJob('<?php echo $post_id ?>', '<?php echo $a['type'] ?>' )">Veja mais</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div>


    <div class="la-fulls-content">
        <?php if ($query_normal->have_posts()) : ?>
            <div class="la-fulls-grid-highlight-content-grid">
                <?php while ($query_normal->have_posts()) : $query_normal->the_post();  ?>
                    <?php
                    $post_id =  get_the_ID();
                    ?>
                    <div>
                        <div class="la-card" onclick="laFullsShowJob('<?php echo $post_id ?>', '<?php echo $a['type'] ?>' )">
                            <div class="la-img">
                                <?php echo la_port_fulls_render_slide_simple($post_id) ?>
                            </div>
                            <div style="padding: 0.3rem 1rem; width: 60%; display: flex; flex-direction: column; justify-content: space-between;">
                                <?php the_title('<h2>', '</h2>'); ?>
                                <div class="d-flex justify-content-center gap-2">
                                    <?php echo la_port_fulls_render_tecnolog($post_id) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div>
    <script>
        function laPortFullGetIframe($url) {
            var html = '<?php echo la_port_fulls_render_iframe() ?>';
            html = html.replace("#url-content#", $url);
            document.querySelector("body").innerHTML += html;
        }

        function laRemoveIframe(event) {
            event.target.closest(".la-port-fulls-modal-bg").remove()
        };
    </script>
<?php
    return ob_get_clean();
    die();
}
add_shortcode('la_port_fulls', 'la_port_fulls_render');



function    la_port_fulls_render_tecnolog($post_id, $size = 30)
{
    $term_list = get_the_terms($post_id, LA_PORT_FULL_TAX);
    $tax = LA_PORT_FULL_TAX . "-img";

    $onclick = "";

?>

    <?php foreach ($term_list as $term) : ?>
        <?php
        $image = get_term_meta($term->term_id, $tax, true);
        echo '<img src="' . $image . '" width="' . $size . '" height="' . $size . '"  title="' . $term->name . '" class="" style="object-fit: contain" ' .  $onclick . ' />'
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

    <?php if ($img_json != null && $img_json != '') : ?>
        <div id="la-port-fulls-img-<?php echo $post_id ?>" class="la-port-fulls-carousel-content">
            <?php if (count($img_json) > 2): ?>
                <button class="btn-prev" onclick="laPortFullSlideShow(this, 'prev')">
                    <img src="<?php echo LA_PORT_FULL_URL . "assets/media/next.svg" ?>" alt="">
                </button>
            <?php endif; ?>
            <div class="la-port-fulls-carousel">
                <?php foreach ($img_json as $key => $value) : ?>
                    <?php
                    $pos_x =  $last_element === $value && count($img_json) > 1 ? -100 : 100 * $key;
                    if ($modal) {
                        $img_zoom =  wp_get_attachment_image_url($value, "full");
                        $event = 'onclick="window.open(\'' . $img_zoom . '\', \'_blank\'); return false"';
                    }
                    ?>
                    <img style="left: <?php echo  $pos_x  ?>%" class="img-show" src='<?php echo wp_get_attachment_image_url($value, "medium_large") ?>' loading="lazy" <?php echo $event ?> />
                <?php endforeach; ?>
            </div>


            <?php if (count($img_json) > 2): ?>
                <button class="btn-next" onclick="laPortFullSlideShow(this, 'next')">
                    <img src="<?php echo LA_PORT_FULL_URL . "assets/media/next.svg" ?>" alt="">
                </button>
            <?php endif; ?>
        </div>
        <?php if ($modal): ?>
            <div class="la-indicators-content">
                <?php for ($i = 0; $i < count($img_json); $i++): ?>
                    <div class="la-indicators-content-item <?php echo $i == 0 ? "active" : "" ?>">

                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
<?php
}


function la_port_fulls_render_slide_simple($post_id)
{
    $img_json = get_post_meta($post_id, 'la_port_fulls_galeria_imgs', true);
?>

    <?php if ($img_json != null && $img_json != '') : ?>
        <img style="width: 100%; object-fit: cover; height: 100%;" src='<?php echo wp_get_attachment_image_url($img_json[0], "medium_large") ?>' alt=" First slide" loading="lazy" />
    <?php endif; ?>

<?php
}


function la_port_fulls_render_post($post_id)
{
    ob_start();
    $postPort =  get_post($post_id);
    $content = $postPort->post_content;
    $title = $postPort->post_title;

    $has_index = false;
    $conteudo_url = "";


    $nome_conteudo = get_post_meta($post_id, '_portfolio_nome_conteudo', true);
    if (!empty($nome_conteudo)) {
        $file_save = Port_Upload::get_url_path($nome_conteudo);
        $conteudo_url = $file_save["content_url"];
        $has_index = file_exists($file_save["content_path"] . "/index.html");
    }

?>

    <div class="la-port-fulls-modal-bg">
        <div class="la-port-fulls-modal">

            <button class="btn-close" onclick="this.closest('.la-port-fulls-modal-bg').remove(); return false">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="gray" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                </svg>
            </button>

            <div class="la-port-fulls-modal-img">
                <?php la_port_fulls_render_slide($post_id, true) ?>
            </div>
            <div class="la-port-fulls-modal-detalhes">

                <div class="la-port-fulls-modal-detalhes-body">
                    <h3><?php echo $title ?></h3>
                    <div>
                        <?php echo wpautop($content) ?>
                    </div>
                    <?php if ($conteudo_url !=  "" &&  $has_index) : ?>
                        <div>
                            <a class="la-btn" href="<?php echo $conteudo_url ?>" target="_blank" style="max-width: max-content; margin: auto;">Mostrar Conteúdo</a>

                        </div>
                    <?php endif; ?>
                </div>
                <div class="la-port-fulls-modal-detalhes-footer">
                    <hr>
                    <div style=" display: flex;flex-wrap: wrap ;justify-content: center; margin-top: 1rem; gap: 1.5rem">
                        <?php echo la_port_fulls_render_tecnolog($post_id, '50') ?>
                    </div>
                </div>
            </div>

        </div>
    </div>


<?php
    return ob_get_clean();
}



function la_port_fulls_render_iframe()
{
    ob_start();
?>
    <div class="la-port-fulls-modal-bg">
        <div style="width: 90vw; height: 90vh; position: relative; border-radius: 15px; overflow: hidden;">

            <button class="btn-close" onclick="laRemoveIframe(event)">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                </svg>
            </button>

            <iframe src="#url-content#" frameborder="0" style="width: 100%; height: 100%" loading="_laze"></iframe>

        </div>
    </div>
    </div>

<?php
    return str_replace(array("\r", "\n"), '',  trim(ob_get_clean()));
}


function custom_mime_types($mimes)
{
    $mimes['zip'] = 'application/zip';
    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');
