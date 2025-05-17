<?php









function la_port_fulls_render_slide_simple($post_id)
{
    $img_json = get_post_meta($post_id, 'la_port_fulls_galeria_imgs', true);
?>

    <?php if ($img_json != null && $img_json != '') : ?>
        <img style="width: 100%; object-fit: cover; height: 100%;" src='<?php echo wp_get_attachment_image_url($img_json[0], "medium_large") ?>' alt="Image slide Carrousel" loading="lazy" />
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


function la_custom_mime_types($mimes)
{
    $mimes['zip'] = 'application/zip';
    return $mimes;
}
add_filter('upload_mimes', 'la_custom_mime_types');
