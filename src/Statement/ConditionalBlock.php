<?php
/**
 * @author: yevgen
 * @date  : 17.06.17
 */

namespace YevgenGrytsay\TelegramIvParser\Statement;

use YevgenGrytsay\TelegramIvParser\Context;
use YevgenGrytsay\TelegramIvParser\Expression\CompositeCondition;
use YevgenGrytsay\TelegramIvParser\Statement;

class ConditionalBlock implements Statement
{
    /**
     * @var CompositeCondition
     */
    private $condition;
    /**
     * @var Statement[]
     */
    private $statements = [];

    /**
     * ConditionalBlock constructor.
     * @param CompositeCondition $condition
     * @param Statement[]        $statements
     */
    public function __construct(CompositeCondition $condition, array $statements)
    {
        $this->condition = $condition;
        $this->statements = $statements;
    }

    /**
     * @param Context $context
     * @throws \Exception
     */
    public function execute(Context $context)
    {
        if ($this->condition->evaluate($context)) {
            array_walk($this->statements, function (Statement $stmt) use ($context) {
                $stmt->execute($context);
            });
        }
    }

    public function __toString()
    {
        return (string) $this->condition . "\n" . implode("\n", $this->statements);
    }
}