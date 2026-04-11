<?php
declare(strict_types=1);

function handle_upload(string $method): void {
    if ($method !== 'POST') json_error('Method not allowed', 405);

    if (empty($_FILES['file'])) json_error('Файл не передан (поле "file")', 400);
    $file = $_FILES['file'];
    if ($file['error'] !== UPLOAD_ERR_OK) json_error('Ошибка загрузки: ' . $file['error'], 400);

    $config = app_config()['uploads'];
    if ($file['size'] > $config['max_bytes']) {
        json_error('Файл слишком большой', 413);
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!isset($config['mime_whitelist'][$mime])) {
        json_error('Недопустимый тип файла', 415);
    }

    $dims = @getimagesize($file['tmp_name']);
    if ($dims === false) json_error('Файл не является изображением', 415);

    $ext = $config['mime_whitelist'][$mime];
    $name = bin2hex(random_bytes(16)) . '.' . $ext;
    $target = rtrim($config['path'], '/') . '/' . $name;

    if (!is_dir($config['path'])) {
        @mkdir($config['path'], 0755, true);
    }
    if (!move_uploaded_file($file['tmp_name'], $target)) {
        json_error('Не удалось сохранить файл', 500);
    }
    @chmod($target, 0644);

    $url = rtrim($config['public_url'], '/') . '/' . $name;
    json_out(['url' => $url], 201);
}
