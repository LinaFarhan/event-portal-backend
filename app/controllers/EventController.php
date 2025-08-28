<?php
namespace App\Controllers;

use App\Core\Response;
use App\Services\EventService;

class EventController extends BaseController
{
    protected $eventService;

    public function __construct()
    {
        parent::__construct();
        $this->eventService = new EventService();
    }

    public function index()
    {
        $events = $this->eventService->getAllEvents();
        Response::json($events);
    }

    public function show($id)
    {
        $event = $this->eventService->getEventById($id);
        
        if (!$event) {
            Response::json(['error' => 'Event not found'], 404);
            return;
        }

        Response::json($event);
    }

    public function store()
    {
        $user = Auth::validateToken();
        $data = $this->getRequestData();

        $validation = $this->validateEventData($data);
        if (!$validation['valid']) {
            Response::json(['errors' => $validation['errors']], 400);
            return;
        }

        $data['created_by'] = $user['id'];
        $eventId = $this->eventService->createEvent($data);

        Response::json([
            'message' => 'Event created successfully',
            'id' => $eventId
        ], 201);
    }

    public function update($id)
    {
        $user = Auth::validateToken();
        $event = $this->eventService->getEventById($id);

        if (!$event) {
            Response::json(['error' => 'Event not found'], 404);
            return;
        }

        // التحقق من أن المستخدم هو منشئ الفعالية
        if ($event['created_by'] != $user['id']) {
            Response::json(['error' => 'Unauthorized'], 403);
            return;
        }

        $data = $this->getRequestData();
        $validation = $this->validateEventData($data);
        
        if (!$validation['valid']) {
            Response::json(['errors' => $validation['errors']], 400);
            return;
        }

        $this->eventService->updateEvent($id, $data);

        Response::json(['message' => 'Event updated successfully']);
    }

    public function destroy($id)
    {
        $user = Auth::validateToken();
        $event = $this->eventService->getEventById($id);

        if (!$event) {
            Response::json(['error' => 'Event not found'], 404);
            return;
        }

        if ($event['created_by'] != $user['id']) {
            Response::json(['error' => 'Unauthorized'], 403);
            return;
        }

        $this->eventService->deleteEvent($id);

        Response::json(['message' => 'Event deleted successfully']);
    }

    private function validateEventData($data)
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'Title is required';
        }

        if (empty($data['date'])) {
            $errors['date'] = 'Date is required';
        } elseif (!strtotime($data['date'])) {
            $errors['date'] = 'Invalid date format';
        }

        if (empty($data['time'])) {
            $errors['time'] = 'Time is required';
        }

        if (empty($data['location'])) {
            $errors['location'] = 'Location is required';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}