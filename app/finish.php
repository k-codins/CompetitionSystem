<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Moto\Service\ResultsManager;
use Moto\Service\RoundGenerator;

$roundGenerator = new RoundGenerator();
$participantsWithRounds = $roundGenerator->addRoundsResultToParticipants(3);

$resultManager = new ResultsManager($participantsWithRounds);

$sortedByTimeAndClassParticipants = $resultManager->getParticipantsSortedByTimeAndClass();
$firstPlaces = $resultManager->getWinners();

var_dump($firstPlaces);
