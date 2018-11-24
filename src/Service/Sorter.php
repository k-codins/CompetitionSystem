<?php

namespace Moto\Service;

class Sorter
{
    /**
     * @param string $fieldName
     * @param array $data
     * @return array
     */
    public function sortByField(string $fieldName, array $data): array
    {
        usort($data, function ($a, $b) use ($fieldName) {
            if ($a->{$fieldName} == $b->{$fieldName}) return 0;
            return ($a->{$fieldName} < $b->{$fieldName}) ? -1 : 1;
        });

        return $data;
    }
}
