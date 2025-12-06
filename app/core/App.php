<?php
class App {
    private $controller = null;
    private $method = 'index';
    private $params = [];

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        $url = $this->parseUrl();
        
        // Tentukan controller name
        $controllerName = isset($url[0]) ? ucfirst(strtolower($url[0])) . 'Controller' : 'MahasiswaController';
        
        // Cek apakah class sudah ada (sudah di-load di index.php)
        if (class_exists($controllerName)) {
            $this->controller = new $controllerName();
            unset($url[0]);
        } else {
            $this->notFound("Controller tidak ditemukan: $controllerName");
            return;
        }

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        
        switch ($httpMethod) {
            case 'GET':
                if (isset($url[1]) && is_numeric($url[1])) {
                    $this->method = 'show';
                    $this->params = [$url[1]];
                } else {
                    $this->method = 'index';
                }
                break;

            case 'POST':
                $this->method = 'create';
                break;

            case 'PUT':
            case 'PATCH':
                if (isset($url[1]) && is_numeric($url[1])) {
                    $this->method = 'update';
                    $this->params = [$url[1]];
                } else {
                    $this->methodNotAllowed("ID diperlukan untuk UPDATE");
                    return;
                }
                break;

            case 'DELETE':
                if (isset($url[1]) && is_numeric($url[1])) {
                    $this->method = 'delete';
                    $this->params = [$url[1]];
                } else {
                    $this->methodNotAllowed("ID diperlukan untuk DELETE");
                    return;
                }
                break;

            default:
                $this->methodNotAllowed("Method $httpMethod tidak didukung");
                return;
        }

        if (method_exists($this->controller, $this->method)) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            $this->notFound("Method {$this->method} tidak ditemukan di controller");
        }
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(
                rtrim($_GET['url'], '/'), 
                FILTER_SANITIZE_URL
            ));
        }
        return [];
    }

    private function notFound($message = "Resource tidak ditemukan") {
        http_response_code(404);
        echo json_encode([
            'success' => false, 
            'message' => $message
        ], JSON_PRETTY_PRINT);
        exit();
    }

    private function methodNotAllowed($message = "Method tidak diizinkan") {
        http_response_code(405);
        echo json_encode([
            'success' => false, 
            'message' => $message
        ], JSON_PRETTY_PRINT);
        exit();
    }
}