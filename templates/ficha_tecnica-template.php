<?php


function la_port_fullstack_ficha_tecnica($attr, $content)
{
    la_port_fullstack_enqueue();
    ob_start();
?>
    <div class="la-ficha-container">
        <h3>Ficha Técnica</h3>
        <div>
            <?php echo $content ?>
        </div>
    </div>


<?php
    $content = ob_get_contents();
    ob_get_clean();
    return $content;
}
