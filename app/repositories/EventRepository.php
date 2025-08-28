<?php
namespace App\Repositories;

use App\Models\Event;
use PDO;

class EventRepository
{
    protected $model;

    public function __construct(PDO $db)
    {
        $this->model = new Event($db);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function getUpcomingEvents()
    {
        return $this->model->getUpcomingEvents();
    }

    public function getUserEvents($userId)
    {
        return $this->model->getEventsByUser($userId);
    }

    public function getEventWithSpeakers($eventId)
    {
        return $this->model->getWithSpeakers($eventId);
    }
}