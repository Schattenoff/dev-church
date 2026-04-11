<?php
declare(strict_types=1);

function handle_upload(): void {
    if (empty($_FILES['file'])) json_error('Файл не передан');
    $file = $_FILES['file'];
    if ($file['error'] !== UPLOAD_ERR_OK) json_error('Ошибка загрузки');

    $config = app_config()['uploads'];
    if ($file['size'] > $config['max_bytes']) json_error('Файл слишком большой');

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!isset($config['mime_whitelist'][$mime])) json_error('Недопустимый тип файла');

    if (@getimagesize($file['tmp_name']) === false) json_error('Файл не является изображением');

    $ext = $config['mime_whitelist'][$mime];
    $name = bin2hex(random_bytes(16)) . '.' . $ext;
    $target = rtrim($config['path'], '/') . '/' . $name;

    if (!is_dir($config['path'])) @mkdir($config['path'], 0755, true);
    if (!move_uploaded_file($file['tmp_name'], $target)) json_error('Не удалось сохранить файл');
    @chmod($target, 0644);

    $url = rtrim($config['public_url'], '/') . '/' . $name;
    json_ok(['url' => $url]);
}
