<?php
// app/core/Request.php
namespace App\Core;

class Request {
    public array $get;
    public array $post;
    public ?array $json;
    public string $method;
    public array $headers;

    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->headers = function_exists('getallheaders') ? (getallheaders() ?: []) : [];
        $input = file_get_contents('php://input');
        $this->json = $input ? json_decode($input, true) : null;
    }
}