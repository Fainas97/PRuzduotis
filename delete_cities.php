<?php
session_start();
require_once('load.php');

$db = new Database();

$db->deleteCity($_POST['city_id']);
$_SESSION['success'] = 1;
exit(header('Location: cities.php?id=' . urlencode($_POST['country_id'])));