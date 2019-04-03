<?php
session_start();
require_once('load.php');

$db = new Database();

$db->deleteCountry($_POST['country_id']);
$_SESSION['success'] = 1;
exit(header('Location: countries.php'));