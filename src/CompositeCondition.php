<?php

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
     * @param array $consitions
     */
    public function __construct(array $consitions)
    {
        $this->conditions = $consitions;
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
}