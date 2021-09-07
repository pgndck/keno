<?php


namespace Keno;


class Helper
{

    public static function getColumnRange(int $column)
    {
        $range = range(max(1, $column * 10), $column * 10 + self::getLastColumnModifier($column));
        shuffle($range);

        return $range;
    }

    public static function getLastColumnModifier($column) {
        return $column == 8 ? 10 : 9;
    }
}