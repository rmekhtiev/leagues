<?php

namespace App\Services;

class RandomizeService
{
    public function getRandomWeightedElement(array $weightedValues)
    {
        $rand = mt_rand(1, (int)array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }

    public function calculatePercentage($num_amount, $num_total): string
    {
        return number_format($num_amount / $num_total * 100);
    }
}
