<?php



function la_port_fullstack_get_menu($cpt)
{
    $args = array(
        'post_type' => $cpt,
        "post_status" => 'publish',
    );

    return get_posts($args);
}


function la_port_fullstack_render($cpt)
{

    la_port_fullstack_enqueue();
    $nav_items = la_port_fullstack_get_menu($cpt);
    $url = get_permalink();

    $has_get = (isset($_GET['i']) && is_string($_GET['i']) && $_GET['i'] != "");


    $args = array(
        'post_type' => $cpt,
        'post_status' => 'publish',
        'posts_per_page' => 1
    );
    if ($has_get) {
        $args['name'] = sanitize_title($_GET['i']);
    }

    the_content();
?>

    <div class="la-dev-container">
        <nav>
            <ul>
                <?php foreach ($nav_items as $item): ?>
                    <li>
                        <a href="<?= $url . "?i=" . $item->post_name ?>" aria-label="Conteúdo iframe">
                            <div class="iframe-content-nav-item">
                                <div>
                                    <span>
                                        <?php echo $item->post_title ?>
                                    </span>

                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <article>
            <div class="nav-sel">
                <select name="" id="" onchange="selPage(this)">
                    <option value="">Selecione</option>
                    <?php foreach ($nav_items as $item): ?>
                        <option value="<?php echo $item->post_name ?>" ?>
                            <?php echo $item->post_title ?>
                        </option>
                    <?php endforeach; ?>

                </select>
                <script>
                    function selPage($this) {
                        window.location.href = "<?= $url ?>?i=" + $this.value;
                    }
                </script>
            </div>
            <div class="iframe-content">
                <?php
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) {
                    while ($the_query->have_posts()) {
                        $the_query->the_post();
                        the_content();
                    }
                } else {
                    esc_html_e('Sem Conteúdo cadastrado');
                }
                // Restore original Post Data.
                wp_reset_postdata();

                ?>
            </div>
        </article>
    </div>
<?php
}
