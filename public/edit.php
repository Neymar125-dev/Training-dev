<?php
require "../src/bootstrap.php";

use App\Calendar\Events;
use App\Calendar\EventValidator;

//dd($_GET,$_POST);
//require "../src/Calendar/Events.php"; 
$pdo = get_pdo();
$errors = [];

$events = new Events($pdo);
try {
    $event = $events->find($_GET['id'] ?? null);
} catch (Exception $e) {
    e404();
} catch (Error $er) {
    e404();
}
$data = [
    'name' => $event->getName(),
    'date' => $event->getStart()->format('Y-m-d'),
    'start' => $event->getStart()->format('H:i'),
    'end' => $event->getEnd()->format('H:i'),
    'description' => $event->getDescription(),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $errors = [];
    $validator = new EventValidator();
    $errors = $validator->validates($data);
    if (empty($errors)) {
        $events->hydrate($event, $data);
        //$events = new Events(get_pdo());
        $events->update($event);
        header('location: /index?action=success&type=modification');
        exit();
        //dd($event);
    }
}
render('header', ['title' => $event->getName(),]);
?>
<div class="container">
    <h1>Editer l'évènement <small> <?= h($event->getName()); ?></small></h1>
    <form action="" method="POST" class="form">
        <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Modifier l'évèvenement </button>
        </div>
    </form>
    <form action="delete.php?id=<?= $event->getId(); ?>" method="POST">
        <div><button class="btn btn-primary">supprimer</button></div>
    </form>
</div>

<?php
render('footer');
?>