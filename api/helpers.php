<?php
declare(strict_types=1);

function json_out(array $data): void {
    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function json_ok(array $data = []): void {
    json_out(array_merge(['error' => false], $data));
}

function json_error(string $message): void {
    json_out(['error' => true, 'message' => $message]);
}

function read_input(): array {
    $raw = file_get_contents('php://input');
    if ($raw === '' || $raw === false) return [];
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function new_id(): string {
    return bin2hex(random_bytes(8));
}

function str_field(array $data, string $key, int $maxLen = 1000): string {
    $value = isset($data[$key]) ? (string) $data[$key] : '';
    $value = trim($value);
    if (mb_strlen($value) > $maxLen) $value = mb_substr($value, 0, $maxLen);
    return $value;
}
