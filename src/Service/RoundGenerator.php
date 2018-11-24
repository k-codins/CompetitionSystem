<?php

namespace Moto\Service;

use Moto\Model\Participant;
use Moto\Model\Round;

class RoundGenerator
{
    /**
     * @var array|Participant[]
     */
    private $participants = [];

    function __construct()
    {
        $this->participants = (new ParticipantsManager())->getAll();
    }

    /**
     * @param int $numberOfRounds
     * @return array|Participant[]
     */
    public function addRoundsResultToParticipants(int $numberOfRounds): array
    {
        foreach ($this->participants as $participant) {
            for ($i = 0; $i < $numberOfRounds; $i++) {
                $participant->round[] = $this->generateRound();
            }
        }
        return $this->participants;
    }

    /**
     * @return Round
     */
    public function generateRound(): Round
    {
        $isCompleted = (bool)rand(0, 10);
        $innerTime = $this->generateTime();
        $penalty = (bool)rand(0, 1) ? $this->generatePenalty() : '';
        $round = new Round($innerTime, $penalty, $isCompleted);
        return $round;
    }

    /**
     * @return int
     */
    private function generateTime(): int
    {
        return rand(18000, 54000);
    }

    /**
     * @return string
     */
    private function generatePenalty(): string
    {
        $penalties = ['hand', 'foot', 'cone'];
        return rand(1, 5) . ' ' . $penalties[rand(0, 2)];
    }
}
