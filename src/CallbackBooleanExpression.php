<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class CallbackBooleanExpression implements Expression
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * CallbackBooleanExpression constructor.
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param $context
     * @return mixed
     */
    public function evaluate($context)
    {
        return call_user_func($this->callback, $context);
    }
}