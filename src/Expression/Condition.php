<?php
namespace YevgenGrytsay\TelegramIvParser\Expression;

use YevgenGrytsay\TelegramIvParser\Context;
use YevgenGrytsay\TelegramIvParser\Expression;
use YevgenGrytsay\TelegramIvParser\ParserException;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class Condition implements Expression
{
    const COND_EXISTS = 'exists';
    /**
     * @var
     */
    private $required;
    /**
     * @var Expression
     */
    private $expr;

    public static function parse($string)
    {
        if (preg_match('#^([\?\!])([a-z_]+)$#', $string, $matches) && in_array($matches[2], ['true', 'false'], true)) {
            $val = filter_var($matches[2], FILTER_VALIDATE_BOOLEAN);
            return new Constant($val);
        }

        $conditions = [self::COND_EXISTS];
        if (preg_match('#^([\?\!])([a-z_]+):(.+)$#', $string, $matches) && in_array($matches[2], $conditions, true)) {
            return self::createUnary($matches[1], $matches[2], $matches[3]);
        }

        throw new ParserException(sprintf('String "%s" is invalid unary condition', $string));
    }

    public static function createUnary($require, $name, $arg)
    {
        switch ($name) {
            case self::COND_EXISTS:
                return new Condition($require === '!', new Callback(function (Context $context) use ($arg) {
                    $els = $context->findXpath($arg);

                    return $els->length > 0;
                }));
            default:
                return null;
        }
    }

    /**
     * Condition constructor.
     * @param $required
     * @param Expression $expr
     */
    public function __construct($required, Expression $expr)
    {
        $this->required = $required;
        $this->expr = $expr;
    }

    /**
     * @return mixed
     */
    public function isRequired()
    {
        return $this->required;
    }

    public function evaluate($context)
    {
        return $this->expr->evaluate($context);
    }

    public function __toString()
    {
        return ($this->required ? '!' : '?') . (string) $this->expr;
    }
}