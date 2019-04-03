<?php
session_start();
require_once('load.php');

$db = new Database();

$newCountries = array (
    'Salis' => preg_replace('/\s+/', '', $_POST['name'])
);

if (!empty($newCountries['Salis'])) {
    $db->addCountry($newCountries);
    $_SESSION['success'] = 1;
    exit(header('Location: countries.php'));
} else {
    $_SESSION['error'] = "Šalies pavadinimas negali būti tusčias!";
    exit(header('Location: countries.php'));
}