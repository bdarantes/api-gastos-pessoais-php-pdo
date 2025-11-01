<?php

use App\config\Database;
use App\controllers\LoginController;

$db = (new Database())->connect();
$controller = new LoginController($db);
$controller->handleRequest();