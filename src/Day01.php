<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;

class Day01
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputAsLines();

        $position = 50;
        $numberOfPointingAtZero = 0;

        foreach ($content as $line) {
            match ($line[0]) {
                'L' => $position -= (int) substr($line, 1),
                'R' => $position += (int) substr($line, 1),
            };

            while ($position < 0) {
                $position += 100;
            }
            $position %= 100;

            if ($position === 0) {
                $numberOfPointingAtZero++;
            }
        }

        return "$numberOfPointingAtZero";
    }

    public function partTwo(): string
    {
        $content = $this->readInputAsLines();

        $position = 50;
        $previousPosition = $position;
        $numberOfPointingAtZero = 0;
        foreach ($content as $line) {
            $direction = $line[0];
            $diff = (int) substr($line, 1);
            $subCountNumberPointingAtZero = 0;
            match ($direction) {
                'L' => $position -= $diff,
                'R' => $position += $diff,
            };

            while ($position < 0) {
                $position += 100;
            }
            $position %= 100;

            // Every full rotation gets a "pointing at zero"
            $subCountNumberPointingAtZero += intdiv($diff, 100);
            // If we crossed the 0 (or) 100 between the previous position and the current we add one again
            if ($direction === 'L' && $position > $previousPosition && $previousPosition !== 0 && $position !== 0) {
                $subCountNumberPointingAtZero++;
            }
            if ($direction === 'R' && $position < $previousPosition && $previousPosition !== 0 && $position !== 0) {
                $subCountNumberPointingAtZero++;
            }
            if ($position === 0) {
                $subCountNumberPointingAtZero++;
            }

            $previousPosition = $position;
            $numberOfPointingAtZero += $subCountNumberPointingAtZero;
        }

        return "$numberOfPointingAtZero";
    }
}