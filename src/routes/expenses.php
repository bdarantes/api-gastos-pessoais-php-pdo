<?php

use App\config\Database;
use App\controllers\ExpenseController;

$db = (new Database())->connect();
$controller = new ExpenseController($db);
$controller->handleRequest();