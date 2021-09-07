<?php


namespace Keno;


class PlayingCard
{

    const COLUMNS = 9;
    const ROWS = 3;
    const TEMPLATE = [
        [1, 2, 3, 4, 5, 6, 7, 8, 9],
        [10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
        [20, 21, 22, 23, 24, 25, 26, 27, 28, 29],
        [30, 31, 32, 33, 34, 35, 36, 37, 38, 39],
        [40, 41, 42, 43, 44, 45, 46, 47, 48, 49],
        [50, 51, 52, 53, 54, 55, 56, 57, 58, 59],
        [60, 61, 62, 63, 64, 65, 66, 67, 68, 69],
        [70, 71, 72, 73, 74, 75, 76, 77, 78, 79],
        [80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90],
    ];

    private int   $cardNumber;
    private array $field;

    public function __construct(int $cardNumber = 0)
    {
        $this->cardNumber = $cardNumber;

        $this->populateField();
    }

    public function populateField(): void
    {
        $tempField = [];

        foreach (range(0, self::COLUMNS - 1) as $column) {
            $tempField[$column] = array_slice(Helper::getColumnRange($column), 0, PlayingCard::ROWS);
        }

        foreach ($tempField as $column => $subArray) {
            foreach ($subArray as $row => $number) {
                $this->field[$row][] = $number;
            }
        }

        foreach ($this->field as $rowNumber => $row) {
            $losers = array_rand(range(0, self::COLUMNS - 1), 4);
            foreach ($losers as $loser) {
                $this->field[$rowNumber][$loser] = null;
            }
        }
    }

    /**
     * @return array
     */
    public function getField(): array
    {
        return $this->field;
    }

    /**
     * @return int
     */
    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }
}