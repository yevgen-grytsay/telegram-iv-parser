<?php
namespace YevgenGrytsay\TelegramIvParser;

use YevgenGrytsay\TelegramIvParser\Expression\SingleNodeXpath;
use YevgenGrytsay\TelegramIvParser\Expression\Xpath;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class ExpressionParser
{
    public static function parseExpression($exprString)
    {
        $exprString = trim($exprString);
        $lastIndex = strlen($exprString) - 1;
        if ($exprString[0] === '"' && $exprString[$lastIndex] === '"') {
            return substr($exprString, 1, $lastIndex);
        }

        if ($exprString === 'true' || $exprString === 'false') {
            return filter_var($exprString, FILTER_VALIDATE_BOOLEAN);
        }

        return new SingleNodeXpath(self::parseXpathExpression($exprString));
    }

    public static function parseXpathExpression($exprString)
    {
        $exprString = trim($exprString);
        $contextNodeVarName = null;
        if (preg_match('#^\$([a-z_]+)#', $exprString, $matches)) {
            $contextNodeVarName = $matches[1];
            $exprString = substr($exprString, strlen($contextNodeVarName) + 1);
            $exprString = './/'.ltrim($exprString, '/');
        }

        if (preg_match('#next\-sibling::([a-z1-9]+)#', $exprString, $matches)) {
            $tag = $matches[1];
            $exprString = str_replace($matches[0], 'following-sibling::*[1]/self::'.$tag, $exprString);
        }

//        [has-class("is-imageBackgrounded")]
        if (preg_match('#\[has\-class\(\"([a-z0-9_-]+)"\)\]#i', $exprString, $matches)) {
            $class = $matches[1];
            $exprString = str_replace($matches[0], '[contains(concat(" ", normalize-space(@class), " "), " '.$class.' ")]', $exprString);
        }

        return new Xpath($exprString, $contextNodeVarName);
    }
}