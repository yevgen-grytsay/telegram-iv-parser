<?php
namespace YevgenGrytsay\TelegramIvParser\Expression;

use YevgenGrytsay\TelegramIvParser\Expression;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class CompositeCondition implements Expression
{
    /**
     * @var Condition[]
     */
    private $conditions = [];

    /**
     * CompositeCondition constructor.
     * @param array $conditions
     */
    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @param $context
     * @return mixed
     */
    public function evaluate($context)
    {
        $optResult = null;
        foreach ($this->conditions as $cond) {
            $val = $cond->evaluate($context);
            if ($cond->isRequired() && !$val) {
                return false;
            }
            if (!$cond->isRequired() && $val) {
                $optResult = true;
            }
        }

        return $optResult ?? true;
    }

    public function __toString()
    {
        return implode("\n", array_map(function (Condition $cond) {
            return (string) $cond;
        }, $this->conditions));
    }
}