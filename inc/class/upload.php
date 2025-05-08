<?php




class Port_Upload
{
    private static $name = "port-fulls";

    private static function get_file_name($file)
    {
        $zip_url = sanitize_url($file);
        $file_name = basename($zip_url, '.zip');
        return $file_name;
    }

    public static function save($file)
    {
        $file_name = self::get_file_name($file);
        $file_content = self::get_url_path($file_name);

        // Certifique-se de que a pasta "teste" existe
        if (!file_exists($file_content['content_path'])) {
            mkdir($file_content['content_path'], 0755, true);
        }

        // Descompactar o arquivo ZIP
        $zip = new ZipArchive;
        if ($zip->open($file_content['zip_path']) === TRUE) {
            $zip->extractTo($file_content['content_path']);
            $zip->close();
            return $file_content;
        }

        return false;
    }

    public static function get_url_path($file_name)
    {
        $folder_name = self::$name;
        $folder_content_name = sanitize_title($file_name);

        // Diretório de uploads do WordPress
        $upload_dir = wp_upload_dir();
        $upload_zip_path = $upload_dir['path'] . "/" . $file_name . ".zip";
        $upload_zip_url = $upload_dir['url'] . "/" . $file_name . ".zip";
        $upload_content_path = $upload_dir['basedir'] . "/" . $folder_name . "/" . $folder_content_name;
        $upload_content_url = $upload_dir['baseurl'] . "/" . $folder_name . "/" . $folder_content_name;

        return array(
            "zip_path" => $upload_zip_path,
            "zip_url" => $upload_zip_url,
            "content_url" => $upload_content_url,
            "content_path" => $upload_content_path,
            "name" => $file_name
        );

    }
}