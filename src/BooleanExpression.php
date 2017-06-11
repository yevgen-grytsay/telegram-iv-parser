<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class BooleanExpression implements Expression
{
    /**
     * @var bool|callable
     */
    private $value;

    public static function createUnary($require, $name, $arg)
    {
        switch ($name) {
            case 'exists':
                return new Condition($require === '!', new CallbackBooleanExpression(function (Context $context) use($arg) {
                    $els = $context->findXpath($arg);
                    return $els->length > 0;
                }));
            default:
                return null;
        }
    }

    public function evaluate($context)
    {
        if (is_bool($this->value)) {
            return $this->value;
        }
        return call_user_func($this->value, $context);
    }

    public function append(BooleanExpression $expr)
    {

    }
}