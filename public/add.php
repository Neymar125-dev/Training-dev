<?php

use App\Calendar\Event;
use App\Calendar\Events;
use App\Calendar\EventValidator;
use App\Validator\Validator;

require '../src/bootstrap.php';

$data = [
    'date' => $_GET['date'] ?? date('Y-m-d'),
    'start' => date('H:i'),
    'end' => date('H:i')
];
/*if (isset($_GET['date'])) {
    $data['date'] = $_GET['date'];
}*/
$errors = [];
$validator = new Validator($data);
if (!$validator->validate('date', 'date')) {
    $data['date'] =  date('Y-m-d');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $errors = [];
    $validator = new EventValidator();
    $errors = $validator->validates($_POST);
    if (empty($errors)) {
        $events = new Events(get_pdo());
        $event = $events->hydrate(new Event(), $data);
        $events->create($event);
        header('location: /index?action=success&type=enregistrement');
        exit();
        //dd($event);
    }
}
render('header', ['title' => 'Ajouter un évèvenement']);
?>
<div class="container">
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger"> Merci de corriger vos erreurs</div>
    <?php endif; ?>
</div>

<div class="container">
    <h1>Ajouter un évènement</h1>
    <form action="" method="POST" class="form">
        <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-success">Ajouter l'évèvenement </button>
        </div>
    </form>
</div>
<?php render('footer'); ?>