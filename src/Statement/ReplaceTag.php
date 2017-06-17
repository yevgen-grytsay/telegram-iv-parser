<?php
namespace YevgenGrytsay\TelegramIvParser\Statement;

use YevgenGrytsay\TelegramIvParser\Context;
use YevgenGrytsay\TelegramIvParser\Expression\Xpath;
use YevgenGrytsay\TelegramIvParser\ExpressionParser;
use YevgenGrytsay\TelegramIvParser\Statement;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class ReplaceTag implements Statement
{
    /**
     * @var string
     */
    private $tag;
    /**
     * @var Xpath
     */
    private $target;

    /**
     * ReplaceTag constructor.
     * @param string $tag
     * @param Xpath  $target
     */
    public function __construct($tag, Xpath $target)
    {
        $this->tag = $tag;
        $this->target = $target;
    }

    public static function parse($string)
    {
        if (preg_match('#^<([a-z0-9]+)>:(.+)$#', $string, $matches)) {
            $tag = $matches[1];
            $exprString = $matches[2];
            return new self($tag, ExpressionParser::parseXpathExpression($exprString));
        }

    }

    /**
     * @param Context $context
     * @throws \Exception
     */
    public function execute(Context $context)
    {
        $targetList = $this->target->evaluate($context);
        /** @var \DOMElement $item */
        foreach ($targetList as $item) {
            $newEl = $context->createElement($this->tag);
            foreach ($item->childNodes as $child) {
                $newEl->appendChild($child);
            }
            $item->parentNode->replaceChild($newEl, $item);
        }
    }

    public function __toString()
    {
        return '<'. $this->tag .'>: '. (string) $this->target;
    }
}