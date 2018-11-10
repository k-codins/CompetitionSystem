<?php

use Moto\GroupManager;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../data/database.php';

$groupManager = new GroupManager($participants);

$groupedParticipants = $groupManager->getResult();

print_r($groupedParticipants);
