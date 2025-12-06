<?php
class Controller {
    protected function jsonResponse(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }

    protected function getJsonInput(): ?array {
        $raw = file_get_contents('php://input');
        if (!$raw) return null;
        $input = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid JSON payload'], 400);
        }
        return $input;
    }

    protected function success($data = null, string $message = 'Success', int $code = 200): void {
        $response = ['success' => true, 'message' => $message];
        if ($data !== null) {
            $response['data'] = $data;
        }
        $this->jsonResponse($response, $code);
    }

    protected function error(string $message = 'Error', int $code = 400): void {
        $this->jsonResponse(['success' => false, 'message' => $message], $code);
    }
}