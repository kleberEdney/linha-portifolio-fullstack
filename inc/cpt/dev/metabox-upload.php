<?php


function portfolio_zip_metabox_html($post)
{
    // Campo nonce para verificação de segurança
    wp_nonce_field(basename(__FILE__), 'portfolio_zip_nonce');

    // Obter valor existente, se houver
    $nome_conteudo = get_post_meta($post->ID, '_portfolio_nome_conteudo', true);
    $file_save = Port_Upload::get_url_path($nome_conteudo);
    $zip_file_url = $file_save["zip_url"];
    $conteudo_url = $file_save["content_url"];
    $has_index = file_exists($file_save["content_path"] . "/index.html");
?>
    <p>
        <label for="portfolio_zip">Nome Conteúdo:</label><br />
        <input id="content-name" type="text" name="_portfolio_nome_conteudo" value="<?php echo $nome_conteudo; ?>"
            style="width: 100%;" readonly />
    </p>

    <button type="button" class="button portfolio_upload_button">Upload ZIP</button>
    <hr>
    <p>
        <label for="portfolio_zip">Upload ZIP File:</label><br />
        <input id="input-zip-url" type="url" id="portfolio_zip" value="<?php echo $zip_file_url; ?>" style="width: 100%;"
            readonly />
    </p>



    <div class="show-url">
        <label for="">Conteúdo</label></br>
        <input id="input-content-url" type="url" value="<?php echo esc_url($conteudo_url) ?>" readonly />
        <?php if ($conteudo_url != ""): ?>
            <?php if ($has_index): ?>
                <button onclick="showContent(event)">
                    Show Conteúdo
                </button>
            <?php else: ?>
                <h4>Sem Index no arquivo</h4>
            <?php endif ?>
        <?php endif; ?>
    </div>

    <script>
        function showContent(e) {
            e.preventDefault()
            var url = document.querySelector("#input-content-url").value;
            console.log(url)
            if (url != "") {
                window.open(url, '_blank').focus();
            }
        }

        jQuery(document).ready(function($) {
            var custom_uploader;
            $('.portfolio_upload_button').click(function(e) {
                e.preventDefault();
                // Se o uploader já estiver aberto, não faça nada
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
                // Extensões permitidas
                var allowed_file_types = ['zip'];
                // Criar o uploader e fazer o upload
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose ZIP File',
                    button: {
                        text: 'Choose ZIP File'
                    },
                    multiple: false,
                    library: {
                        type: allowed_file_types
                    }
                });
                custom_uploader.on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    var url = attachment.url;
                    var fileName = attachment.name;
                    salvarZip(url, fileName);
                });
                custom_uploader.open();
            });

            function salvarZip(zipUrl, nameFile) {
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php') ?>", // URL do admin-ajax.php
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'set_portifolio_path_file', // Nome da ação registrada no PHP
                        zip_url: zipUrl,
                        file_name: nameFile,
                    },
                    success: function(resp) {
                        if (resp.success) {
                            $('#input-zip-url').val(zipUrl);
                            $('#input-content-url').val(resp.fileContent.content_url);
                            $('#content-name').val(resp.fileContent.name);
                        }
                        alert(resp.msg)
                        return resp.success;
                    },
                    error: function() {
                        alert('Ocorreu um erro ao processar a requisição.');
                    }
                });
            }

        });
    </script>
<?php
}
