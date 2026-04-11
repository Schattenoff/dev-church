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

function fetch_ministries(): array {
    $rows = db()->query('SELECT id, title, description, schedule, leader, image FROM ministries ORDER BY sort_order ASC, created_at ASC')->fetchAll();
    return $rows ?: [];
}

function handle_ministries(string $method, ?string $id): void {
    if ($method === 'GET') {
        json_out(fetch_ministries());
    }

    if ($method === 'POST') {
        $data = read_json_body();
        $row = ministry_row($data, new_id());
        $stmt = db()->prepare('INSERT INTO ministries (id, title, description, schedule, leader, image, sort_order) VALUES (:id, :title, :description, :schedule, :leader, :image, 0)');
        $stmt->execute($row);
        json_out($row, 201);
    }

    if ($method === 'PUT' && $id !== null) {
        $data = read_json_body();
        $row = ministry_row($data, $id);
        $stmt = db()->prepare('UPDATE ministries SET title=:title, description=:description, schedule=:schedule, leader=:leader, image=:image WHERE id=:id');
        $stmt->execute($row);
        if ($stmt->rowCount() === 0) {
            $check = db()->prepare('SELECT id FROM ministries WHERE id=:id');
            $check->execute(['id' => $id]);
            if (!$check->fetch()) json_error('Not found', 404);
        }
        json_out($row);
    }

    if ($method === 'DELETE' && $id !== null) {
        $stmt = db()->prepare('DELETE FROM ministries WHERE id=:id');
        $stmt->execute(['id' => $id]);
        json_out(['ok' => true]);
    }

    json_error('Method not allowed', 405);
}
