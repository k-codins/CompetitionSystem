<?php

namespace Moto\Service;

use Moto\Model\Participant;

class ParticipantsManager
{
    /**
     * @var array|Participant[]
     */
    private $participants = [];

    function __construct()
    {
        $usersInfo = require_once __DIR__ . '/../../data/database.php';

        foreach ($usersInfo as $userInfo) {
            $participant = new Participant();
            $participant->id = $userInfo['id'];
            $participant->class = $userInfo['class'];
            $participant->name = $userInfo['name'];
            $participant->moto = $userInfo['moto'];
            $this->participants[] = $participant;
        }
    }

    /**
     * @return array|Participant[]
     */
    public function getAll(): array
    {
        return $this->participants;
    }
}
