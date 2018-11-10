<?php

namespace Moto;

interface GroupManagerInterface
{
    public function sortArrayByColumn(array $array, string $columnName = null, $arraySortOrder = SORT_ASC);
}
