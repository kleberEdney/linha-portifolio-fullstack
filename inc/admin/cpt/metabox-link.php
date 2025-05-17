<?php
function la_port_fulls_render_link($post)
{
    $link = get_post_meta($post->ID, 'la_port_fulls_links', true);
    $link_label = get_post_meta($post->ID, 'la_port_fulls_links_label', true);
?>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
        <div>
            <label for="la_port_fulls_links">Link</label></br>
            <input type="url" value="<?php echo $link ?>" name="la_port_fulls_links">
        </div>
        <div>
            <label for="la_port_fulls_links_label">Label</label></br>
            <input type="text" value="<?php echo $link_label ?>" name="la_port_fulls_links_label">
        </div>
    </div>

<?php
}
