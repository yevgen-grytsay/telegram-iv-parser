<?php
/**
 * @author: yevgen
 * @date  : 17.06.17
 */

namespace YevgenGrytsay\TelegramIvParser\Expression;


use YevgenGrytsay\TelegramIvParser\Context;
use YevgenGrytsay\TelegramIvParser\Expression;

class Callback implements Expression
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * Callback constructor.
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param Context $context
     * @return mixed
     * @throws \Exception
     */
    public function evaluate($context)
    {
        return call_user_func($this->callback, $context);
    }

    public function __toString()
    {
        return '[callback expression]';
    }
}