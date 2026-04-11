<?php
declare(strict_types=1);

function news_row(array $data, string $id): array {
    return [
        'id'          => $id,
        'title'       => str_field($data, 'title', 500),
        'description' => str_field($data, 'description', 5000),
        'date'        => str_field($data, 'date', 64),
        'image'       => str_field($data, 'image', 1000),
    ];
}

function fetch_news(): array {
    $rows = db()->query('SELECT id, title, description, date, image FROM news ORDER BY sort_order ASC, created_at DESC')->fetchAll();
    return $rows ?: [];
}

function handle_news(string $method, ?string $id): void {
    if ($method === 'GET') {
        json_out(fetch_news());
    }

    if ($method === 'POST') {
        $data = read_json_body();
        $row = news_row($data, new_id());
        $stmt = db()->prepare('INSERT INTO news (id, title, description, date, image, sort_order) VALUES (:id, :title, :description, :date, :image, 0)');
        $stmt->execute($row);
        json_out($row, 201);
    }

    if ($method === 'PUT' && $id !== null) {
        $data = read_json_body();
        $row = news_row($data, $id);
        $stmt = db()->prepare('UPDATE news SET title=:title, description=:description, date=:date, image=:image WHERE id=:id');
        $stmt->execute($row);
        if ($stmt->rowCount() === 0) {
            $check = db()->prepare('SELECT id FROM news WHERE id=:id');
            $check->execute(['id' => $id]);
            if (!$check->fetch()) json_error('Not found', 404);
        }
        json_out($row);
    }

    if ($method === 'DELETE' && $id !== null) {
        $stmt = db()->prepare('DELETE FROM news WHERE id=:id');
        $stmt->execute(['id' => $id]);
        json_out(['ok' => true]);
    }

    json_error('Method not allowed', 405);
}
