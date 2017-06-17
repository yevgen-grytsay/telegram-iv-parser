<?php
namespace YevgenGrytsay\TelegramIvParser;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
interface Expression
{
    /**
     * @param Context $context
     * @return mixed
     * @throws Exception
     */
    // TODO: use RuntimeException
    public function evaluate($context);
}