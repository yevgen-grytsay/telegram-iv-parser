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
                return null;
//                throw new Exception(sprintf('Context node can not be null (key: "%s")', $this->ctxNodeVarName));
            }
        }
//        $nodes = $context->findXpath($this->expression, $ctxNode);
        /** @var \DOMElement $ctxNode */
        if ($ctxNode) {
            $path = $ctxNode->getNodePath() . $this->expression;
            $nodes = $context->findXpath($path);
        } else {
            $nodes = $context->findXpath($this->expression);
        }

//        if (!$nodes->length) {
//            throw new \Exception(sprintf('Node not found (xpath: "%s")', $this->expression));
//        }

        return $nodes->length ? $nodes->item(0) : null;
    }
}