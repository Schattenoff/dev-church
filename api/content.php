<?php
declare(strict_types=1);

require_once __DIR__ . '/news.php';
require_once __DIR__ . '/ministries.php';
require_once __DIR__ . '/schedule.php';

function handle_content(string $method): void {
    if ($method !== 'GET') json_error('Method not allowed', 405);
    json_out([
        'news'       => fetch_news(),
        'ministries' => fetch_ministries(),
        'schedule'   => fetch_schedule(),
    ]);
}
