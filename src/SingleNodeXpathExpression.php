<?php
namespace YevgenGrytsay\TelegramIvParser;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class SingleNodeXpathExpression implements Expression
{
    /**
     * @var XpathExpression
     */
    private $expr;

    /**
     * SingleNodeXpathExpression constructor.
     * @param XpathExpression $expr
     */
    public function __construct(XpathExpression $expr)
    {
        $this->expr = $expr;
    }

    /**
     * @param $context
     * @return mixed
     * @throws Exception
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