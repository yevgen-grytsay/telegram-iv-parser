<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
interface Statement
{
    public function run(Context $context);
}