<?php

declare(strict_types=1);

namespace BeeGame\Util;

class RandomPicker
{
    /**
     * Picks randomly a value from one of the groups
     *
     * @param array[] $groupedValues
     *
     * @return mixed
     */
    public function pick(array $groupedValues)
    {
        $partitions = array_values($groupedValues);
        if ([] === $partitions) {
            throw new \InvalidArgumentException('Groups list cannot be empty.');
        }

        // choose randomly a group
        $partitionIndex = mt_rand(0, count($partitions) - 1);
        $values = $partitions[$partitionIndex];
        if ([] === $values) {
            throw new \InvalidArgumentException('At least one value must be present in a group.');
        }

        // and then a value within the group
        return $values[mt_rand(0, count($values) - 1)];
    }
}
