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

function handle_news(string $action, array $data): void {
    if ($action === 'get') {
        $rows = db()->query('SELECT id, title, description, date, image FROM news ORDER BY sort_order ASC, created_at DESC')->fetchAll() ?: [];
        json_ok(['news' => $rows]);
    }

    if ($action === 'save') {
        $id = isset($data['id']) && $data['id'] !== '' ? (string) $data['id'] : null;

        if ($id === null) {
            $row = news_row($data, new_id());
            $stmt = db()->prepare('INSERT INTO news (id, title, description, date, image, sort_order) VALUES (:id, :title, :description, :date, :image, 0)');
            $stmt->execute($row);
            json_ok(['news' => $row]);
        }

        $row = news_row($data, $id);
        $stmt = db()->prepare('UPDATE news SET title=:title, description=:description, date=:date, image=:image WHERE id=:id');
        $stmt->execute($row);
        json_ok(['news' => $row]);
    }

    if ($action === 'delete') {
        $id = isset($data['id']) ? (string) $data['id'] : '';
        if ($id === '') json_error('id обязателен');
        $stmt = db()->prepare('DELETE FROM news WHERE id=:id');
        $stmt->execute(['id' => $id]);
        json_ok();
    }

    json_error('Неизвестное действие');
}
