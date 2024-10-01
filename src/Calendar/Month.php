<?php

namespace App\Calendar;

use DateTimeImmutable;
use Exception;

class Month
{
    public $days  = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $month;
    public $year;
    /**
     * Month constructor
     * @param int $month Le mois compris entre 1 et 12 
     * @param int $year L'année
     * @throws Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null || $month < 1 || $month > 12) {
            $month = intval(date('m'));
        }
        if ($year == null) {
            $year = intval(date('Y'));
        }


        if ($year < 1970) {
            throw new Exception("l'année $year est inférieur à 1970");
        }
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Renvoi le premier jour du mois
     * @return DateTimeImmutable
     */
    public function getStartingDate(): \DateTimeInterface
    {
        return new DateTimeImmutable("{$this->year}-{$this->month}-01");
    }
    /**
     * Retourne le mois en toute lettre(exemple: Septembre 2024)
     * @return string
     */
    public function toString(): string
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }
    /**
     * Renvoie le nombre de semaine dans le mois
     * @return int
     */
    public function getWeeks(): int
    {
        $start = $this->getStartingDate();
        $end = $start->modify('+1 month -1 day');
        $startWeek = intval($start->format('W'));
        $endWeek = intval($end->format('W'));
        if ($endWeek === 1) {
            $endWeek = intval($end->modify('-7 days')->format('W')) + 1;
        }
        $weeks = $endWeek - $startWeek + 1;
        if ($weeks < 0) {
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }
    /**
     * Est-ce que le jour est dans le mois en cours
     * @return bool 
     */
    public function isWithinMounth(\DateTimeInterface $date): bool
    {
        return $this->getStartingDate()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoi le moi suivant
     * @return Month
     */
    public function nextMonth(): Month
    {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * Renvoi le moi précédent
     * @return Month
     */
    public function previusMonth(): Month
    {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}
