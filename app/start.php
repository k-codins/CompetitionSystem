<?php

use Moto\Service\ParticipantsManager;
use Moto\Service\Sorter;

require_once __DIR__ . '/../vendor/autoload.php';

$participantsManager = new ParticipantsManager();
$participants = $participantsManager->getAll();

$sorter = new Sorter();
$sortedByClass = $sorter->sortByField('class', $participants);

var_dump($sortedByClass);
