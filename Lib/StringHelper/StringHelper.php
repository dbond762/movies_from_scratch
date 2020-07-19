<?php

namespace Lib\StringHelper;

class StringHelper {
    /**
     * Проверяет, заканчивается ли строка указанной подстрокой
     *
     * @param string $str
     * @param string $end
     *
     * @return bool
     */
    public static function ends_with(string $str, string $end) : bool {
        return substr($str, -strlen($end)) === $end;
    }

    /**
     * Удалить с конца строки построку
     *
     * @param string $str
     * @param string $end
     *
     * @return string
     */
    public static function cute_from_end(string $str, string $end) : string {
        if (!self::ends_with($str, $end)) {
            return false;
        }

        return substr($str, 0, strlen($str) - strlen($end));
    }
}
