<div class="la-fulls-content">
    <?php if ($query_highlights->have_posts()) : ?>
        <div class="la-fulls-grid-highlight-content">
            <?php while ($query_highlights->have_posts()) : $query_highlights->the_post();  ?>
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
                            <?php the_title('<h2 style="font-size:2rem">', '</h2>'); ?>
                            <?php the_excerpt() ?>

                        </div>
                        <div class="la-card-footer">
                            <div style="display: flex; flex-wrap: wrap; ; margin-top: 1rem; justify-content: center; gap: 1rem">
                                <?php echo la_port_fulls_render_tecnolog($post_id) ?>
                            </div>
                            <div>
                                <a href="<?= permalink_link($post_id) ?>" aria-label="Acesse Conteúdo desenvolvido">
                                    <button aria-label="Vej Mais" class="la-btn">Veja mais</button>
                                </a>
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
    // function laPortFullGetIframe($url) {
    //     var html = '<?php //echo la_port_fulls_render_iframe() 
                        ?>';
    //     html = html.replace("#url-content#", $url);
    //     document.querySelector("body").innerHTML += html;
    // }

    function laRemoveIframe(event) {
        event.target.closest(".la-port-fulls-modal-bg").remove()
    };
</script>