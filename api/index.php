<?php
declare(strict_types=1);

require __DIR__ . '/db.php';
require __DIR__ . '/helpers.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Пинг для ручной проверки из браузера
if ($method === 'GET') {
    json_ok(['service' => 'dev-church api']);
}

if ($method !== 'POST') {
    json_error('Only POST is allowed');
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$path = preg_replace('#^/api/?#', '', $uri);
$path = trim((string) $path, '/');
$segments = $path === '' ? [] : explode('/', $path);

$resource = $segments[0] ?? '';
$action = $segments[1] ?? '';

try {
    if ($resource === 'upload') {
        require __DIR__ . '/upload.php';
        handle_upload();
        exit;
    }

    $input = read_input();
    $data = isset($input['data']) && is_array($input['data']) ? $input['data'] : [];

    switch ($resource) {
        case 'news':
            require __DIR__ . '/news.php';
            handle_news($action, $data);
            break;

        case 'ministries':
            require __DIR__ . '/ministries.php';
            handle_ministries($action, $data);
            break;

        case 'schedule':
            require __DIR__ . '/schedule.php';
            handle_schedule($action, $data);
            break;

        default:
            json_error('Неизвестный ресурс');
    }
} catch (Throwable $e) {
    error_log('[api] ' . $e->getMessage());
    json_error('Ошибка сервера');
}
