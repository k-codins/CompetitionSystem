<?php

namespace Moto\Service;

use Moto\Model\Participant;

class ResultsManager
{
    /**
     * @var array|Participant[]
     */
    private $participants = [];

    /**
     * @var Sorter
     */
    private $sorter;

    /**
     * ResultsManager constructor.
     * @param array| Participant[] $participants
     */
    function __construct(array $participants)
    {
        $this->participants = $participants;
        $this->sorter = new Sorter();
    }

    /**
     * @return array
     */
    public function getWinners(): array
    {
        $participants = $this->getParticipantsSortedByTimeAndClass();
        $result = [];
        $result[] = $this->getWinnerByClassAndTime($participants, 'A');
        $result[] = $this->getWinnerByClassAndTime($participants, 'B');
        $result[] = $this->getWinnerByClassAndTime($participants, 'C');
        return $result;
    }

    /**
     * @return array
     */
    public function getParticipantsSortedByTimeAndClass(): array
    {
        $fieldName1 = 'class';
        $fieldName2 = 'bestTime';
        $data = $this->getParticipantsWithoutZeroResult();
        usort($data, function ($a, $b) use ($fieldName1, $fieldName2) {
            return $a->{$fieldName1} <=> $b->{$fieldName1} ?: $a->{$fieldName2} <=> $b->{$fieldName2};
        });

        return $data;
    }

    /**
     * @return array
     */
    private function setBestRoundResultToParticipant(): array
    {
        $result = [];
        foreach ($this->participants as $participant) {
            $bestTime = 0;

            /** @var Participant $sortedByBestTotalTime */
            $sortedByBestTotalTime = $this->sorter->sortByField('totalTime', $participant->round);
            foreach ($sortedByBestTotalTime as $totalTime) {
                if ($totalTime !== 0) {
                    $bestTime = $totalTime->totalTime;
                    break;
                }
            }
            $participant->bestTime = $bestTime;
            $result[] = $participant;
        }
        return $result;
    }

    /**
     * @param array|Participant[] $participants
     * @param string $className
     * @return Participant|null
     * @internal param string $className
     */
    private function getWinnerByClassAndTime(array $participants, string $className): ?Participant
    {
        $winner = null;
        foreach ($participants as $participant) {
            if ($participant->class == $className) {
                $winner = $participant;
            }
        }
        return $winner;
    }

    /**
     * @return array| Participant[]
     */
    private function getParticipantsWithoutZeroResult(): array
    {
        $allParticipants = $this->setBestRoundResultToParticipant();
        $result = [];
        foreach ($allParticipants as $participant) {
            if ($participant->bestTime !== 0) {
                $result[] = $participant;
            }
        }
        return $result;
    }
}
