<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
interface Expression
{
    /**
     * @param $context
     * @return mixed
     * @throws Exception
     */
    // TODO: use RuntimeException
    public function evaluate($context);
}