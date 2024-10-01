<?php
require "../src/bootstrap.php";

use App\Calendar\Events;

//dd($_GET,$_POST);
//require "../src/Calendar/Events.php"; 
$pdo = get_pdo();
if (!isset($_GET['id'])) {
    header('location: /404.php');
}
$events = new Events($pdo);
try {
    $event = $events->find($_GET['id'] ?? null);
} catch (Exception $e) {
    e404();
}

render('header', ['title' => $event->getName(),]);
?>

<h1><?= h($event->getName()); ?></h1>
<ul>
    <li>Date: <?= $event->getStart()->format('d/m/y'); ?></li>
    <li>Heure de démarrage: <?= $event->getStart()->format('H:i'); ?></li>
    <li>Heure de fin: <?= $event->getEnd()->format('H:i'); ?></li>
    <li>Déscription: <br>
        <?= h($event->getDescription()); ?>
    </li>
</ul>
<?php
require "../views/footer.php";
?>