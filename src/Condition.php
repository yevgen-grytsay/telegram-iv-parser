<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class Condition implements Expression
{
    /**
     * @var
     */
    private $required;
    /**
     * @var Expression
     */
    private $expr;

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

    public static function parse($string)
    {
        if (preg_match('#^([\?\!])([a-z_]+)$#', $string, $matches) && in_array($matches[2], ['true', 'false'], true)) {
            $val = filter_var($matches[2], FILTER_VALIDATE_BOOLEAN);
            return new BooleanExpression($val);
        }

        $conditions = [BooleanExpression::COND_EXISTS];
        if (preg_match('#^([\?\!])([a-z_]+):(.+)$#', $string, $matches) && in_array($matches[2], $conditions, true)) {
            return BooleanExpression::createUnary($matches[1], $matches[2], $matches[3]);
        }

        throw new ParserException(sprintf('String "%s" is invalid unary condition', $string));
    }
}