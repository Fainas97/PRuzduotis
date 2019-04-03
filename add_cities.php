<?php
session_start();
require_once('load.php');

$db = new Database();
$newCity = array(
    'Miestas' => preg_replace('/\s+/', '', $_POST['name']),
    'SalisId' => $_POST['country_id']
);
if (!empty($newCity['Miestas'])) {
    $db->addCity($newCity);
    $_SESSION['success'] = 1;
    exit(header('Location: cities.php?id=' . urlencode($_POST['country_id'])));
} else {
    $_SESSION['error'] = "Miesto pavadinimas negali būti tusčias!";
    exit(header('Location: cities.php?id='. urlencode($_POST['country_id'])));
}