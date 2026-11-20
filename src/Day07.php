<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;

class Day07
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $answer = 0;
        $columnsWithBeam = [
            strpos($lines[0], 'S'),
        ];
        array_shift($lines);
        $tmp = [];

        foreach ($lines as $line) {
            foreach ($columnsWithBeam as $columnWithBeam) {
                // Find splitters at current beams
                if($line[$columnWithBeam] === '^') {
                    $answer++;
                    $tmp[] = $columnWithBeam - 1;
                    $tmp[] = $columnWithBeam + 1;
                } else {
                    $tmp[] = $columnWithBeam;
                }
            }

            $columnsWithBeam = array_unique($tmp);
            $tmp = [];
        }

        return (string) $answer;
    }

    public function partTwo(): string
    {
        $content = $this->readInput();
        $answer = 0;

        return (string) $answer;
    }
}