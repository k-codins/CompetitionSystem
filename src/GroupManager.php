<?php

namespace Moto;

class GroupManager implements GroupManagerInterface
{
    /**
     * @var array
     */
    private $participants;

    public function __construct(array $participants)
    {
        $this->participants = $participants;
    }

    public function sortArrayByColumn(array $participants, string $columnName = null, $arraySortOrder = SORT_ASC)
    {
        if (!is_null($columnName)) {
            $targetColumn = array_column($participants, $columnName);
            array_multisort($targetColumn, $arraySortOrder, $participants);
        } else {
            array_multisort($participants, $arraySortOrder, $participants);
        }
        return $participants;
    }

    public function getResult()
    {
        return $this->sortArrayByColumn($this->participants, 'class');
    }
}
