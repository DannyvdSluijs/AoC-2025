<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;

class Day05
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInput();
        [$ranges, $ingredients] = explode("\n\n", $content);
        $ranges = array_map(static function (string $range): array {
            [$start, $end] = explode('-', $range);
            return [(int) $start, (int) $end];
        }, explode("\n", $ranges));
        usort($ranges, static function (array $left, array $right): int {
            return $left[0] <=> $right[0];
        });
        $ingredients = array_map(static function (string $ingredient): int { return (int) $ingredient; }, explode("\n", $ingredients));
        $fresh = [];

        foreach($ingredients as $ingredient) {
            if ($this->isFresh($ingredient, $ranges)) {
                $fresh[] = $ingredient;
            }
        }

        return (string) count($fresh);
    }

    public function partTwo(): string
    {
        $content = $this->readInput();
        [$ranges, $ingredients] = explode("\n\n", $content);
        $ranges = array_map(static function (string $range): array {
            [$start, $end] = explode('-', $range);
            return [(int) $start, (int) $end];
        }, explode("\n", $ranges));
        usort($ranges, static function (array $left, array $right): int {
            return $left[0] <=> $right[0];
        });

        $numberOfFreshIds = 0;
        $current = 0;

        foreach ($ranges as $range) {
            [$start, $end] = $range;
            // Correct for overlap
            if ($current > $start) {
                $start = $current;
            }
            // See if we surpassed the current end of range
            if ($start > $end) {
                continue;
            }
            $numberOfFreshIds += $end - $start + 1;
            $current = $end + 1;
        }

        return (string) $numberOfFreshIds;
    }

    private function isFresh(int $ingredient, array $freshRanges): bool
    {
        return array_any(
            $freshRanges,
            static fn($freshRange) => $freshRange[0] <= $ingredient && $ingredient <= $freshRange[1]
        );
    }
}