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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //$events->hydrate($event, $data);
    //$events = new Events(get_pdo());
    $events->delete($event);
    header('location: /index?action=success&type=suppression');
    exit();
    //dd($event);    }
}
