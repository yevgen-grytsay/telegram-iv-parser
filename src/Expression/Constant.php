<?php
/**
 * @author: yevgen
 * @date  : 17.06.17
 */

namespace YevgenGrytsay\TelegramIvParser\Expression;

use YevgenGrytsay\TelegramIvParser\Context;
use YevgenGrytsay\TelegramIvParser\Expression;

class Constant implements Expression
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * Constant constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param Context $context
     * @return mixed
     * @throws \Exception
     */
    public function evaluate($context)
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}