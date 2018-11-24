<?php

namespace Moto\Model;

class Round
{
    /**
     * @var int
     */
    public $innerTime;

    /**
     * @var string
     */
    public $penalty;

    /**
     * @var bool
     */
    public $isCompleted;

    /**
     * @var int
     */
    public $totalTime = 0;

    function __construct(int $innerTime, string $penalty, bool $isCompleted = false)
    {
        $this->innerTime = $innerTime;
        $this->penalty = $penalty;
        $this->isCompleted = $isCompleted;

        $this->totalTime = $this->countTotalTime();
    }

    /**
     * @return int|null
     */
    public function countTotalTime(): ?int
    {
        if ($this->isCompleted) {
            return $this->innerTime + (int)filter_var($this->penalty, FILTER_SANITIZE_NUMBER_INT);
        }
        return 0;
    }
}
