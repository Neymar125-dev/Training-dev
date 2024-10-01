<?php

namespace App\Calendar;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

class Event
{

    private $id;
    private $name;
    private $description;
    private $start;
    private $end;



    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this->name;
    }

    /**
     * Get the value of description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description ?? '';
    }

    /**
     * Set the value of description
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of start
     * @return DateTimeInterface
     */
    public function getStart(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->start);
    }

    /**
     * Set the value of start
     * @return  self
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get the value of end
     *@return DateTimeInterface
     */
    public function getEnd(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->end);
    }

    /**
     * Set the value of end
     * @return  self
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }
}
