<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class LineParser
{

    public function parse($string)
    {
        if (!trim($string)) {
            return null;
        }
        if ($string[0] === '#' || $string[0] === ' ') {
            return null;
        }

        if (in_array($string[0], ['?', '!'], true)) {
            return Condition::parse($string);
        }

        switch ($string[0]) {
            case '@':
                // function call
                break;
            case '$':
                return VariableAssignment::parse($string);
                break;
            case '<':
                //tag
                break;
            default:
                return PropertyAssignment::parse($string);
        }
    }
}