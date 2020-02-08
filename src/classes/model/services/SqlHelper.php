<?php


namespace Router\Models\Services;


class SqlHelper
{
    /**
     * @phpUnit
     * @param $values
     * @return string
     */
    public static function sqlArrayToIn($values) :string {
        $res = '';

        if (is_array($values) && count($values)) {
            foreach ($values as $value) {
                if (!empty($res) || $res === '0') {
                    $res .= ', ';
                }
                $res .= function_exists('db_quote')
                    ? db_quote($value)
                    : '"' . addslashes($value) . '"';
            }
        }

        return (empty($res) && $res != '0') ? '""' : $res;
    }
    
}
