<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2025;

use Dannyvdsluijs\AdventOfCode2025\Concerns\ContentReader;

class Day03
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputAsGridOfNumbers('');

        $joltages = [];
        foreach ($content as $bank) {
            $bankAsString = implode('', $bank);
            $valueCount = array_count_values($bank);
            $max = max(array_keys($valueCount));
            $subBank = substr($bankAsString, strpos($bankAsString, (string) $max) + 1);

            if ($subBank === '') {
                // edge case max digit was found on far right side.
                unset($valueCount[$max]);
                $max = max(array_keys($valueCount));
                $subBank = substr($bankAsString, strpos($bankAsString, (string) $max) + 1);
            }

            $subBankValueCount = array_count_values(str_split($subBank));
            $subBankMax = max(array_keys($subBankValueCount));

            $joltages[] = (int) ($max . $subBankMax);
        }

        return (string) array_sum($joltages);
    }

    public function partTwo(): string
    {
        $content = $this->readInputAsGridOfNumbers('');

        // Zoeken in het stuk vanaf index 0 of positie van laatst geselecteerde getal tot en met aantal getallen nog te selecteren voor einde
        $joltages = [];
        foreach ($content as $bank) {
            $bankAsString = implode('', $bank);
            $length = strlen($bankAsString);
            $selected = [];
            $lastSelectedIndex = -1;

            while(count($selected) !== 12) {
                $searchString = substr(
                    $bankAsString,
                    $lastSelectedIndex + 1,
                    $length - 11 + count($selected) - $lastSelectedIndex
                );
                $valueCount = array_count_values(str_split($searchString));
                if ($valueCount === []) {
                     // We add the remaining part as selected
                    $lastSelection = str_split(substr($bankAsString, -1 * (12 - count($selected))));
                    $selected = [...$selected, ...$lastSelection];
                    continue;
                }
                $max = max(array_keys($valueCount));

                $positionOfMaxInSearchString = strpos($searchString, (string)$max);
                $selected[] = $max;
                $lastSelectedIndex = $lastSelectedIndex + $positionOfMaxInSearchString + 1;
            }
            $joltages[] = (int) implode('', $selected);
        }

        return (string) array_sum($joltages);
    }
}