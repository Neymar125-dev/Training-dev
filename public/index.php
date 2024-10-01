<?php

use App\Calendar\Events;
use App\Calendar\Month;

require "../src/bootstrap.php";
//require "./src/Calendar/Month.php";
//require "./src/Calendar/Events.php";
$pdo = get_pdo();
$events = new Events($pdo);
$month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDate();
$start = $start->format('N') === '1' ? $start : $month->getStartingDate()->modify('last monday');
$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 * ($weeks - 1)) . 'days');
$events = $events->getEventsBetweenByDay($start, $end);
//var_dump($events); 
require "../views/header.php";
?>
<div class="calendar">
    <div class="d-flex flex-row align-items-center justify-content-between  mx-sm-3">
        <h1><?= $month->toString(); ?></h1>
        <?php if (isset($_GET['action']) && $_GET['action'] === 'success') :
            $action = $_GET['type'];
            switch ($action) {
                case 'enregistrement':
                    $message = "L'évènement a bien été enregistré";
                    break;
                case 'modification':
                    $message = "L'évènement a bien été modifié";
                    break;
                case 'suppression':
                    $message = "L'évènement a bien été supprimé";
                    break;
                default:
                    $message = " L'action a été effectuée avec succès";
            }
        ?>

            <div class="col md-6 text-center">
                <div class="alert alert-success">
                    <?= $message; ?>
                </div>
            </div>
        <?php endif; ?>
        <div>
            <a href="/index.php?month=<?= $month->previusMonth()->month ?>&year=<?= $month->previusMonth()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="/index.php?month=<?= $month->nextMonth()->month ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>


    <table class="calendar__table calendar__table--<?= $weeks; ?>weeks ">
        <?php for ($i = 0; $i < $weeks; $i++) : ?>
            <tr>
                <?php foreach ($month->days as $k => $day) :
                    $date = $start->modify(" + " . ($k + $i * 7) . "days");
                    $eventForDay = $events[$date->format('Y-m-d')] ?? [];
                    $isToday = date('Y-m-d') === $date->format('Y-m-d');
                ?>
                    <td class=" <?= $month->isWithinMounth($date)  ? '' : 'calendar__othermonth'; ?> <?= $isToday ? 'is-today' : ''; ?> ">
                        <?php if ($i === 0) : ?>
                            <div class="calendar__weekday"><?= $day; ?></div>
                        <?php endif; ?>
                        <a class="calendar__day" href="add.php?date=<?= $date->format('Y-m-d'); ?>"><?= $date->format('d'); ?></a>
                        <?php foreach ($eventForDay as $event) : ?>
                            <div class="calendar__events">
                                <?= $event->getStart()->format('H:i') ?> - <a href="/edit.php?id=<?= $event->getId(); ?>"> <?= h($event->getName()); ?></a>
                            </div>
                        <?php endforeach; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor; ?>
    </table>
    <a href="/add.php" class="calendar__button">+</a>
</div>
<?php
require "../views/footer.php";
?>