<?php
session_start();
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)
    ->withServiceAccount(__DIR__.'/phpdb-7380c-firebase-adminsdk-91qv2-9198c772b2.json')
    ->withDatabaseUri('https://phpdb-7380c-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();
?>