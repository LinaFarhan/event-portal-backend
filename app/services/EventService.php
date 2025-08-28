<?php
namespace App\Services;

use App\Repositories\EventRepository;
use App\Repositories\SpeakerRepository;

class EventService
{
    protected $eventRepository;
    protected $speakerRepository;

    public function __construct()
    {
        global $database;
        $this->eventRepository = new EventRepository($database->getPdo());
        $this->speakerRepository = new SpeakerRepository($database->getPdo());
    }

    public function getAllEvents()
    {
        return $this->eventRepository->getAll();
    }

    public function getEventById($id)
    {
        return $this->eventRepository->findById($id);
    }

    public function createEvent(array $data)
    {
        return $this->eventRepository->create($data);
    }

    public function updateEvent($id, array $data)
    {
        return $this->eventRepository->update($id, $data);
    }

    public function deleteEvent($id)
    {
        return $this->eventRepository->delete($id);
    }

    public function getUpcomingEvents()
    {
        return $this->eventRepository->getUpcomingEvents();
    }

    public function getUserEvents($userId)
    {
        return $this->eventRepository->getUserEvents($userId);
    }

    public function addSpeakerToEvent($eventId, $speakerId)
    {
        return $this->eventRepository->addSpeakerToEvent($eventId, $speakerId);
    }

    public function removeSpeakerFromEvent($eventId, $speakerId)
    {
        return $this->eventRepository->removeSpeakerFromEvent($eventId, $speakerId);
    }

    public function getEventWithSpeakers($eventId)
    {
        return $this->eventRepository->getEventWithSpeakers($eventId);
    }
}