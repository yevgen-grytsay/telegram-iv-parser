<?php
namespace YevgenGrytsay\TelegramIvParser;

use YevgenGrytsay\TelegramIvParser\Expression\Condition;
use YevgenGrytsay\TelegramIvParser\Statement\PropertyAssignment;
use YevgenGrytsay\TelegramIvParser\Statement\ReplaceTag;
use YevgenGrytsay\TelegramIvParser\Statement\VariableAssignment;

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

        switch ($string[0]) {
            case '#':
            case ' ':
                return null;
                break;
            case '?':
            case '!':
                return Condition::parse($string);
                break;
            case '@':
                // function call
                break;
            case '$':
                return VariableAssignment::parse($string);
                break;
            case '<':
                return ReplaceTag::parse($string);
                break;
            default:
                return PropertyAssignment::parse($string);
        }
    }
}