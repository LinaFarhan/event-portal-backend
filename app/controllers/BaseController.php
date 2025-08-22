<?php
// app/controllers/BaseController.php
namespace App\Controllers;

use App\Core\Request;

abstract class BaseController {
    protected Request $request;

    public function __construct() {
        $this->request = new Request();
    }

    protected function body(): array {
        return $this->request->json ?? $this->request->post ?? [];
    }
}