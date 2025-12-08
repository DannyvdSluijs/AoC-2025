<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;

class Day06
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputAsGridOfWords();
        $numberOfWorksheetColumns = count($content[0]);

        $results = [];
        for ($i = 0; $i < $numberOfWorksheetColumns; $i++) {
            $column = array_column($content, $i);
            $operation = array_pop($column);
            $results[] = match ($operation) {
                '+' => array_sum($column),
                '*' => array_product($column),
            };
        }

        return (string) array_sum($results);
    }

    public function partTwo(): string
    {
        // The lib uses a trim which is causing issues in this one case.
        $filename = __DIR__ . '/../inputs/day06.txt';
        $content = file_get_contents($filename);
        $lines = explode("\n", $content);
        $content = array_map(str_split(...), $lines);

        $rows = count($content);
        $columns = count($content[0]);
        $results = [];

        $numbers = [];
        $operation = '';
        for ($i = 0; $i < $columns; $i++) {
            $column = array_column($content, $i);
            $valueCount = array_count_values($column);
            $possibleOperation = array_pop($column);

            if ($valueCount === [' ' => $rows]) {
                // Empty column found, end of assignment
                $results[] = match ($operation) {
                    '+' => array_sum($numbers),
                    '*' => array_product($numbers),
                };

                $numbers = [];
                $operation = '';

            } else {
                $numbers[] = (int) implode('', $column);
                if ($possibleOperation !== ' ') {
                    $operation = $possibleOperation;
                }
            }
        }

        // Correct for last set
        $results[] = match ($operation) {
            '+' => array_sum($numbers),
            '*' => array_product($numbers),
        };

        // 10230110 is to low
        return (string) array_sum($results);

    }
}