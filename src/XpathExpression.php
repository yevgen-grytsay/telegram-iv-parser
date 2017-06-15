<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class XpathExpression implements Expression
{
    /**
     * @var string
     */
    private $expression;
    /**
     * @var null|string
     */
    private $ctxNodeVarName;

    /**
     * XpathExpression constructor.
     * @param string $expression
     * @param string|null $ctxNodeVarName
     */
    public function __construct($expression, $ctxNodeVarName = null)
    {
        $this->expression = $expression;
        $this->ctxNodeVarName = $ctxNodeVarName;
    }

    /**
     * @param Context $context
     * @return mixed
     * @throws \Exception
     */
    public function evaluate($context)
    {
        $ctxNode = null;
        if ($this->ctxNodeVarName) {
            $ctxNode = $context->getValue($this->ctxNodeVarName);
            if (!$ctxNode) {
                return new DOMNodeList();
            }
        }

        return $context->findXpath($this->expression, $ctxNode);
    }

    public function __toString()
    {
        if ($this->ctxNodeVarName) {
            return '$'.$this->ctxNodeVarName .'/'. ltrim($this->expression, './');
        }
        return (string) $this->expression;
    }
}