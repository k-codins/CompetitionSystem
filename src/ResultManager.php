<?php

namespace Moto;

class ResultManager
{
    /**
     * @var array
     */
    private $participants;
    /**
     * @var GroupManagerInterface
     */
    private $groupManager;

    public function __construct(array $participants, GroupManagerInterface $groupManager)
    {
        $this->participants = $participants;
        $this->groupManager = $groupManager;
    }

    private function fillRoundResults(array &$participants, int $numberOfRounds = 1)
    {
        $result = [];
        foreach ($participants as $participant) {
            for ($i = 0; $i < $numberOfRounds; $i++) {
                $randomParameters = $this->getRandomTimeAndPenalty();
                $round = $i + 1;
                $participant['time_' . $round] = $randomParameters['time'];
                $participant['penalty_' . $round] = $randomParameters['penalty'];
            }
            $result[] = $participant;
        }
        $participants = $result;

        return $participants;
    }

    private function fillBestScore(array &$participants)
    {
        $result = [];
        foreach ($participants as $participant) {
            $participantTimes = [];
            foreach ($participant as $key => $participantCompetitionParameters) {
                if (strstr($key, 'time')) {
                    $participantTimes[] = $participantCompetitionParameters;
                }
            }
            $sortedByTimes = $this->groupManager->sortArrayByColumn($participantTimes);
            $bestScore = $sortedByTimes[0];
            $participant['best_time'] = $bestScore;
            $result[] = $participant;
        }
        $participants = $result;

        return $participants;
    }

    private function getWinnersByClasses(array &$participants)
    {
        $classColumn = array_column($participants, 'class');
        $bestTimeColumn = array_column($participants, 'best_time');
        array_multisort($classColumn, SORT_ASC, $bestTimeColumn, SORT_ASC, $participants);

        $winnerByGroups = [];

        foreach ($participants as $participant) {
            $winnerA = false;
            $winnerB = false;
            $winnerC = false;

            if ($participant['class'] === 'A' && !$winnerA) {
                $winnerByGroups[] = $participant;
                $winnerA = true;
            } elseif ($participant['class'] === 'B' && !$winnerB) {
                $winnerByGroups[] = $participant;
                $winnerB = true;
            } elseif ($participant['class'] === 'C' && !$winnerC) {
                $winnerByGroups[] = $participant;
                $winnerC = true;
            }
        }
        return $winnerByGroups;
    }

    private function getRandomTimeAndPenalty()
    {
        $randTime = random_int(0, time());
        $timeForRound = date('i:s', $randTime);

        $penalty = rand(0, 5);

        return [
            'time' => $timeForRound,
            'penalty' => $penalty
        ];
    }

    public function getResult(int $numberOfRounds)
    {
        $this->fillRoundResults($this->participants, $numberOfRounds);
        $this->fillBestScore($this->participants);
        return $this->getWinnersByClasses($this->participants);
//        return $this->participants;
    }
}






















