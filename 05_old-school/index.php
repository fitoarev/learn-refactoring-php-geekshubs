<?php
require_once __DIR__ . '/bootstrap.php';

$task = new Queue();
$task->setDao(new Dao('localhost', 'www', '123456', 'refactory'));
$task->setMailer(new Mailer());
$task->run();