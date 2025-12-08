<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;

class Day02
{
    use ContentReader;

    public function partOne(): string
    {
        $ranges = $this->getProcessedInput();

        $invalidIds = [];

        foreach ($ranges as $range) {
            [$start, $end] = $range;

            while ($start <= $end) {
                $length = strlen((string)$start);

                if ($length % 2 === 1) {
                    // For uneven length go to the next number with even number of digits
                    $start = 10 ** $length;
                    continue;
                }

                [$left, $right] = str_split((string) $start, intdiv($length, 2));

                if ($left !== $right) {
                    $start++;
                    continue;
                }

                $invalidIds[] = $start;
                $start++;
            }
        }

        return (string) array_sum($invalidIds);
    }

    public function partTwo(): string
    {
        $ranges = $this->getProcessedInput();

        $invalidIds = [];

        foreach ($ranges as $range) {
            [$start, $end] = $range;

            while ($start <= $end) {
                if ($this->isInvalidPartTwo($start)) {
                    $invalidIds[] = $start;
                }

                $start++;
            }
        }
        return (string) array_sum($invalidIds);
    }

    private function isInvalidPartTwo(int $in): bool
    {
        $inAsString = (string) $in;
        $inAsArray = str_split($inAsString);
        $length = strlen((string) $in);
        $evenLength = strlen($inAsString) % 2 === 0;
        $multipleOfThreeLength = $length % 3 === 0;
        $valueCount = array_count_values($inAsArray);
        $allSameNumbers = count($valueCount) === 1;

        if ($length === 1) {
            return false;
        }

        if ($allSameNumbers) {
            return true;
        }

        if ($evenLength) {
            [$left, $right] = str_split($inAsString, intdiv($length, 2));
            if ($left === $right) {
                return true;
            }

            if ($length >= 4) {
                $parts = str_split($inAsString, 2);
                $partCount = array_count_values($parts);
                if (count($partCount) === 1) {
                    return true;
                }
            }
        }

        if ($multipleOfThreeLength) {
            [$left, $middle, $right] = str_split($inAsString, intdiv($length, 3));
            if ($left === $middle && $middle === $right) {
                return true;
            }
        }

        return false;
    }

    public function getProcessedInput(): array
    {
        $content = $this->readInput();
        $ranges = array_map(static function (string $in): array {
            [$start, $end] = explode('-', $in);

            return [(int)$start, (int)$end];
        }, explode(',', $content));
        usort($ranges, static fn($a, $b) => $a[0] <=> $b[0]);
        return $ranges;
    }
}