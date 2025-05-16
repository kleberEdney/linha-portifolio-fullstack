<?php

function save_portfolio_zip_meta($post_id)
{
    // Verificação de autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    ;

    $meta_key = '_portfolio_nome_conteudo';



    if (isset($_POST[$meta_key])) {
        update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$meta_key]));
    } else {
        delete_post_meta($post_id, $meta_key);
    }

}
add_action('save_post_' . LA_PORT_FULL_CPT_DEV, 'save_portfolio_zip_meta');



function set_portifolio_path_file()
{

    $file = $_POST['zip_url'];
    try {
        //code...
        $files_save = Port_Upload::save($file);
        $resp = array(
            "success" => true,
            "msg" => "Arquivo salvo com sucesso!",
            "fileContent" => $files_save,
        );
    } catch (\Exception $e) {
        $resp = array(
            "success" => false,
            "msg" => "Erro ao salvar conteúdo!",
            "fileContent" => null,
        );
    }


    echo json_encode($resp);
    die();
}
// function set_portifolio_path_file()
// {



//     $file_content = get_path_url_file_upload();

//     // Certifique-se de que a pasta "teste" existe
//     if (!file_exists($file_content['path'])) {
//         mkdir($file_content['path'], 0755, true);
//     }

//     // Descompactar o arquivo ZIP
//     $zip = new ZipArchive;
//     if ($zip->open($file_content['zip_path']) === TRUE) {
//         $zip->extractTo($file_content['content_path']);
//         $zip->close();
//         $success = true;
//     }

//     echo json_encode(array(
//         "success" => $success,
//         "fileContent" => $file_content,

//     ));
//     die();
// }

add_action('wp_ajax_set_portifolio_path_file', 'set_portifolio_path_file');
add_action('wp_ajax_nopriv_set_portifolio_path_file', 'set_portifolio_path_file');


function get_path_url_file_upload()
{
    $folder_name = 'port-fulls';
    $zip_url = sanitize_url($_POST['zip_url']);
    $file_name = basename($zip_url, '.zip');
    $folder_content_name = sanitize_title($file_name);


    // Diretório de uploads do WordPress
    $upload_dir = wp_upload_dir();
    $upload_zip_path = $upload_dir['path'] . "/" . $file_name . ".zip";
    $upload_content_path = $upload_dir['basedir'] . "/" . $folder_name . "/" . $folder_content_name;
    $upload_content_url = $upload_dir['baseurl'] . "/" . $folder_name . "/" . $folder_content_name;

    return array(
        "zip_path" => $upload_zip_path,
        "content_url" => $upload_content_url,
        "content_path" => $upload_content_path,
        "name" => $file_name
    );
}


function get_file_path($file_name)
{

}