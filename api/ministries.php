<?php
declare(strict_types=1);

function ministry_row(array $data, string $id): array {
    return [
        'id'          => $id,
        'title'       => str_field($data, 'title', 500),
        'description' => str_field($data, 'description', 5000),
        'schedule'    => str_field($data, 'schedule', 500),
        'leader'      => str_field($data, 'leader', 500),
        'image'       => str_field($data, 'image', 1000),
    ];
}

function handle_ministries(string $action, array $data): void {
    if ($action === 'get') {
        $rows = db()->query('SELECT id, title, description, schedule, leader, image FROM ministries ORDER BY sort_order ASC, created_at ASC')->fetchAll() ?: [];
        json_ok(['ministries' => $rows]);
    }

    if ($action === 'save') {
        $id = isset($data['id']) && $data['id'] !== '' ? (string) $data['id'] : null;

        if ($id === null) {
            $row = ministry_row($data, new_id());
            $stmt = db()->prepare('INSERT INTO ministries (id, title, description, schedule, leader, image, sort_order) VALUES (:id, :title, :description, :schedule, :leader, :image, 0)');
            $stmt->execute($row);
            json_ok(['ministry' => $row]);
        }

        $row = ministry_row($data, $id);
        $stmt = db()->prepare('UPDATE ministries SET title=:title, description=:description, schedule=:schedule, leader=:leader, image=:image WHERE id=:id');
        $stmt->execute($row);
        json_ok(['ministry' => $row]);
    }

    if ($action === 'delete') {
        $id = isset($data['id']) ? (string) $data['id'] : '';
        if ($id === '') json_error('id обязателен');
        $stmt = db()->prepare('DELETE FROM ministries WHERE id=:id');
        $stmt->execute(['id' => $id]);
        json_ok();
    }

    json_error('Неизвестное действие');
}
