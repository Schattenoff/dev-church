<?php
declare(strict_types=1);

const SCHEDULE_DAYS = [
    'понедельник', 'вторник', 'среда', 'четверг',
    'пятница', 'суббота', 'воскресенье',
];

function fetch_schedule(): array {
    $rows = db()->query('SELECT id, day, time, title FROM schedule_events ORDER BY sort_order ASC, time ASC')->fetchAll() ?: [];

    $grouped = [];
    foreach (SCHEDULE_DAYS as $day) {
        $grouped[$day] = ['day' => $day, 'events' => []];
    }
    foreach ($rows as $row) {
        $day = $row['day'];
        if (!isset($grouped[$day])) continue;
        $grouped[$day]['events'][] = [
            'id'    => $row['id'],
            'time'  => $row['time'],
            'title' => $row['title'],
        ];
    }
    return array_values($grouped);
}

function handle_schedule(string $method, ?string $id): void {
    if ($method === 'GET') {
        json_out(fetch_schedule());
    }

    if ($method === 'POST') {
        $data = read_json_body();
        $day = str_field($data, 'day', 32);
        if (!in_array($day, SCHEDULE_DAYS, true)) json_error('Invalid day', 400);
        $row = [
            'id'    => new_id(),
            'day'   => $day,
            'time'  => str_field($data, 'time', 32),
            'title' => str_field($data, 'title', 500),
        ];
        $stmt = db()->prepare('INSERT INTO schedule_events (id, day, time, title, sort_order) VALUES (:id, :day, :time, :title, 0)');
        $stmt->execute($row);
        json_out($row, 201);
    }

    if ($method === 'PUT' && $id !== null) {
        $data = read_json_body();
        $row = [
            'id'    => $id,
            'time'  => str_field($data, 'time', 32),
            'title' => str_field($data, 'title', 500),
        ];
        $stmt = db()->prepare('UPDATE schedule_events SET time=:time, title=:title WHERE id=:id');
        $stmt->execute($row);
        if ($stmt->rowCount() === 0) {
            $check = db()->prepare('SELECT id FROM schedule_events WHERE id=:id');
            $check->execute(['id' => $id]);
            if (!$check->fetch()) json_error('Not found', 404);
        }
        json_out($row);
    }

    if ($method === 'DELETE' && $id !== null) {
        $stmt = db()->prepare('DELETE FROM schedule_events WHERE id=:id');
        $stmt->execute(['id' => $id]);
        json_out(['ok' => true]);
    }

    json_error('Method not allowed', 405);
}
