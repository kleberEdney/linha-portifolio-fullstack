<?php


function la_port_fulls_render_galeria()
{
    $post_id = get_the_ID();
    la_port_fullstack_galeria_admin();

    $img_json = get_post_meta($post_id, 'la_port_fulls_galeria_imgs', true);
    $icon_trash = LA_PORT_FULL_URL . '/assets/media/lixo.svg';
    $icon_move = LA_PORT_FULL_URL . '/assets/media/move.svg';
?>

    <div class="">
        <h4>Galeria</h4>
        <p>Máximo: 12 imagens</p>
        <button id='btn-galeia' class='button button-primary button-large'>ADICIONAR IMAGEM(s)</button>
        </br>
        <div id='my-galery' class="la-port-fulls-content">
            <?php if ($img_json != null && $img_json != '') : ?>
                <?php foreach ($img_json as $key => $value) : ?>
                    <div class="img-prev-content" style="">
                        <img class="img-prev" src='<?php echo wp_get_attachment_image_url($value, "medium_large") ?>' />
                        <img class='btn trash' onclick='removeImg(event)' src='<?php echo $icon_trash ?>' />
                        <img class='btn sortle' src='<?php echo $icon_move ?>' />
                        <input type='hidden' value='<?php echo $value; ?>' name='la_port_fulls_galeria_imgs[]' />
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <h3 id="txt-sem-img" class="text-center">Sem imagens</h3>
            <?php endif; ?>
        </div>
    </div>

    <script>
        var apagarBtn = "<?php echo $icon_trash; ?>"
        var apagarMove = "<?php echo $icon_move; ?>"
    </script>

<?php
}


?>