<?php
declare(strict_types=1);


namespace BallGame\Domain;


class BinaryGap
{
    public function calculate(int $number): int
    {
        $binaryRepresentation = decbin($number);

        $gaps = explode('1', $binaryRepresentation);

        array_pop($gaps);
        array_shift($gaps);

        $binaryGap = 0;
        foreach ($gaps as $gap) {
            if (strlen($gap) > $binaryGap) {
                $binaryGap = strlen($gap);
            }
        }

        return $binaryGap;
    }
}
