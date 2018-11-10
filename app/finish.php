<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../data/database.php';

use Moto\GroupManager;
use Moto\ResultManager;

$groupManager = new GroupManager($participants);

$groupedParticipants = $groupManager->getResult();

$resultManager = new ResultManager($groupedParticipants, $groupManager);

$result = $resultManager->getResult(3);
print_r($result);

