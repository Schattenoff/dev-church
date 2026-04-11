<?php
declare(strict_types=1);

const SCHEDULE_DAYS = [
    'понедельник', 'вторник', 'среда', 'четверг',
    'пятница', 'суббота', 'воскресенье',
];

function handle_schedule(string $action, array $data): void {
    if ($action === 'get') {
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
        json_ok(['schedule' => array_values($grouped)]);
    }

    if ($action === 'save') {
        $id = isset($data['id']) && $data['id'] !== '' ? (string) $data['id'] : null;

        if ($id === null) {
            $day = str_field($data, 'day', 32);
            if (!in_array($day, SCHEDULE_DAYS, true)) json_error('Неверный день');
            $row = [
                'id'    => new_id(),
                'day'   => $day,
                'time'  => str_field($data, 'time', 32),
                'title' => str_field($data, 'title', 500),
            ];
            $stmt = db()->prepare('INSERT INTO schedule_events (id, day, time, title, sort_order) VALUES (:id, :day, :time, :title, 0)');
            $stmt->execute($row);
            json_ok(['event' => $row]);
        }

        $row = [
            'id'    => $id,
            'time'  => str_field($data, 'time', 32),
            'title' => str_field($data, 'title', 500),
        ];
        $stmt = db()->prepare('UPDATE schedule_events SET time=:time, title=:title WHERE id=:id');
        $stmt->execute($row);
        json_ok(['event' => $row]);
    }

    if ($action === 'delete') {
        $id = isset($data['id']) ? (string) $data['id'] : '';
        if ($id === '') json_error('id обязателен');
        $stmt = db()->prepare('DELETE FROM schedule_events WHERE id=:id');
        $stmt->execute(['id' => $id]);
        json_ok();
    }

    json_error('Неизвестное действие');
}
