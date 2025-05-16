<?php


get_header();
la_port_fullstack_enqueue();

$post_id = get_the_ID();
$postPort = get_post($post_id);
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
<style>
    .contant-front {
        display: flex;
        justify-content: center;
        max-width: 1920px;

        margin: auto;
        gap: 3rem;
        padding-top: 2rem;
    }

    .slide-content {
        width: 35%;
        position: sticky;
        position: block;
        top: 0;
    }

    .details-content {
        width: 65%;
    }
</style>

<article class="contant-front">
    <div class="slide-content single-pg">
        <?php la_port_fulls_render_slide($post_id, true) ?>
    </div>
    <div class="details-content">

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
            <div style="display: flex;flex-wrap: wrap ;justify-content: center; margin-top: 1rem; gap: 1.5rem">
                <?php echo la_port_fulls_render_tecnolog($post_id, '50') ?>
            </div>
        </div>
    </div>
</article>

<?php
get_footer();
