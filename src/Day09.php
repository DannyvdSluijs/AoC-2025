<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;

class Day09
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines(fn(string $l): array => array_map(intval(...), explode(',', $l)));
        $answer = 0;

        foreach ($lines as $line) {
            foreach ($lines as $other) {
                if ($line[0] >= $other[0]) {
                    continue;
                }

                $size = (abs($line[1] - $other[1]) + 1) * (abs($line[0] - $other[0]) + 1);
                $answer = max($answer, $size);
            }
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