<?php
namespace App\Services;

use App\Repositories\SpeakerRepository;

class SpeakerService
{
    protected $speakerRepository;

    public function __construct()
    {
        global $database;
        $this->speakerRepository = new SpeakerRepository($database->getPdo());
    }

    public function getAllSpeakers()
    {
        return $this->speakerRepository->getAll();
    }

    public function getSpeakerById($id)
    {
        return $this->speakerRepository->findById($id);
    }

    public function createSpeaker(array $data)
    {
        return $this->speakerRepository->create($data);
    }

    public function updateSpeaker($id, array $data)
    {
        return $this->speakerRepository->update($id, $data);
    }

    public function deleteSpeaker($id)
    {
        return $this->speakerRepository->delete($id);
    }

    public function getSpeakersWithEvents()
    {
        return $this->speakerRepository->getSpeakersWithEvents();
    }

    public function addToEvent($speakerId, $eventId)
    {
        return $this->speakerRepository->addToEvent($speakerId, $eventId);
    }

    public function removeFromEvent($speakerId, $eventId)
    {
        return $this->speakerRepository->removeFromEvent($speakerId, $eventId);
    }
}