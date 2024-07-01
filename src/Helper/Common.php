<?php

namespace App\Helper;

class Common
{
    /**
     * Function to generate a random float
     *
     * @param int $decimalAmount    number of decimal after the point
     * @param float $min            minimun value of the range
     * @param float $max            maximun value of the range
     *
     * @return float random float number
     */
    public static function getRandomFloat(int $decimalAmount, float $min, float $max): float
    {
        $divisor = pow(10, $decimalAmount);
        return mt_rand($min, $max * $divisor) / $divisor;
    }
}
