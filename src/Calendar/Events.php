<?php

namespace App\Calendar;

use Exception;
use PDO;
use App\Calendar\Event;
use DateTimeImmutable;

class Events
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * Recupère les évenements commençant 2 dates
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return Event[]
     */
    public function getEventsBetween(DateTimeImmutable $start, DateTimeImmutable $end): array
    {
        $this->pdo =  new PDO('mysql:host=localhost;dbname=tutocalendar', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $sql = "SELECT *FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ORDER BY start ASC ";
        //var_dump($sql);
        $statment = $this->pdo->query($sql);
        $statment->setFetchMode(PDO::FETCH_CLASS, Event::class);
        $result = $statment->fetchAll();
        return $result;
    }

    /**
     * Recupère les évenements commençant 2 dates indéxé par jour
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     * */
    public function getEventsBetweenByDay(DateTimeImmutable $start, DateTimeImmutable $end): array
    {
        $events = $this->getEventsBetween($start, $end);
        $days = [];
        foreach ($events as $event) {
            $date = $event->getStart()->format('Y-m-d');
            if (!isset($days[$date])) {
                $days[$date] = [$event];
            } else {
                $days[$date][] = $event;
            }
        }
        return $days;
    }

    /**
     * Récupère un évenement
     * @param int $id
     * @return Event
     * @throws Exception
     */
    public function find(int $id): Event
    {
        //require 'Event.php';
        $statment = $this->pdo->query("SELECT * FROM events WHERE id = $id LIMIT 1");
        $statment->setFetchMode(PDO::FETCH_CLASS, Event::class);
        $result = $statment->fetch();
        if ($result === false) {
            throw new Exception("Aucun résultat n'a été trouvé");
        } else {
            return $result;
        }
    }
    public function hydrate(Event $event, array $data)
    {
        $event->setName($data['name']);
        $event->setDescription($data['description']);
        $event->setStart(DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start'])->format('Y-m-d H:i:s'));
        $event->setEnd(DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end'])->format('Y-m-d H:i:s'));
        return $event;
    }

    public function create(Event $event): bool
    {
        $statment = $this->pdo->prepare('INSERT INTO events(name, description,start,end) VALUES (?,?,?,?)');
        return $statment->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
        ]);
    }
    public function update(Event $event): bool
    {
        $statment = $this->pdo->prepare('UPDATE events SET name = ?, description = ? , start = ? , end = ? WHERE id = ?');
        return $statment->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getId()
        ]);
    }
    public function delete(Event $event): bool
    {
        $statment = $this->pdo->prepare('DELETE FROM events WHERE id = ?');
        return $statment->execute([
            $event->getId()
        ]);
    }
}
