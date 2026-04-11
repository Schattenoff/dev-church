<?php
declare(strict_types=1);

require __DIR__ . '/db.php';
require __DIR__ . '/helpers.php';

// Простейший роутер: вырезаем /api/ и раскладываем на сегменты.
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$path = preg_replace('#^/api/?#', '', $uri);
$path = trim((string) $path, '/');
$segments = $path === '' ? [] : explode('/', $path);

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$resource = $segments[0] ?? '';
$id = $segments[1] ?? null;

try {
    switch ($resource) {
        case '':
            json_out(['ok' => true, 'service' => 'dev-church api']);
            break;

        case 'content':
            require __DIR__ . '/content.php';
            handle_content($method);
            break;

        case 'news':
            require __DIR__ . '/news.php';
            handle_news($method, $id);
            break;

        case 'ministries':
            require __DIR__ . '/ministries.php';
            handle_ministries($method, $id);
            break;

        case 'schedule':
            require __DIR__ . '/schedule.php';
            handle_schedule($method, $id);
            break;

        case 'upload':
            require __DIR__ . '/upload.php';
            handle_upload($method);
            break;

        default:
            json_error('Not found', 404);
    }
} catch (Throwable $e) {
    error_log('[api] ' . $e->getMessage());
    json_error('Internal error', 500);
}
