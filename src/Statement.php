<?php
/**
 * @author: yevgen
 * @date  : 17.06.17
 */

namespace YevgenGrytsay\TelegramIvParser;


interface Statement
{
    /**
     * @param \YevgenGrytsay\TelegramIvParser\Context $context
     * @throws \Exception
     */
    public function execute(Context $context);
}