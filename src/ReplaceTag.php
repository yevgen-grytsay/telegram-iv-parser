<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class ReplaceTag implements Expression
{
    /**
     * @var string
     */
    private $tag;
    /**
     * @var XpathExpression
     */
    private $target;

    /**
     * ReplaceTag constructor.
     * @param string $tag
     * @param XpathExpression $target
     */
    public function __construct($tag, XpathExpression $target)
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
     * @return mixed
     * @throws Exception
     */
    public function evaluate($context)
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