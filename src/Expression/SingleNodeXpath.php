<?php
namespace YevgenGrytsay\TelegramIvParser\Expression;

use YevgenGrytsay\TelegramIvParser\Expression;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class SingleNodeXpath implements Expression
{
    /**
     * @var Xpath
     */
    private $expr;

    /**
     * SingleNodeXpathExpression constructor.
     * @param Xpath $expr
     */
    public function __construct(Xpath $expr)
    {
        $this->expr = $expr;
    }

    /**
     * @param $context
     * @return mixed
     * @throws \Exception
     */
    public function evaluate($context)
    {
        $nodes = $this->expr->evaluate($context);
        if ($nodes->length) {
            return $nodes->item(0);
        }
        return null;
    }

    public function __toString()
    {
        return (string) $this->expr;
    }
}