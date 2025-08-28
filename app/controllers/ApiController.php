<?php
namespace App\Controllers;

use App\Core\Response;
use App\Services\EventService;
use App\Services\SpeakerService;

class ApiController extends BaseController
{
    protected $eventService;
    protected $speakerService;

    public function __construct()
    {
        parent::__construct();
        $this->eventService = new EventService();
        $this->speakerService = new SpeakerService();
    }

    public function options()
    {
        // للتعامل مع طلبات OPTIONS لـ CORS
        Response::json(['message' => 'OK']);
    }

    public function notFound()
    {
        Response::json(['error' => 'Endpoint not found'], 404);
    }

    public function methodNotAllowed()
    {
        Response::json(['error' => 'Method not allowed'], 405);
    }
}