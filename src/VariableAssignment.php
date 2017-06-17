<?php
namespace YevgenGrytsay\TelegramIvParser;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class VariableAssignment implements Expression
{
    /**
     * @var Expression
     */
    private $expr;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $preserve;

    /**
     * PropertyAssignment constructor.
     * @param string $name
     * @param Expression $expr
     * @param $preserve
     */
    public function __construct($name, Expression $expr, $preserve= false)
    {
        $this->expr = $expr;
        $this->name = $name;
        $this->preserve = $preserve;
    }

    public static function parse($string)
    {
        preg_match('#^\$([a-z_0-9]+)([?])?:(.+)#', $string, $matches);
        if (!$matches) {
            throw new ParserException(sprintf('String "%s" is not valid variable assignment', $string));
        }
        $name = $matches[1];
        $qm = $matches[2];
        $exprString = $matches[3];

        $preserve = count($qm) > 0;

        return new PropertyAssignment($name, ExpressionParser::parseExpression($exprString), $preserve);
    }

    /**
     * @param Context $context
     * @return mixed
     */
    public function evaluate($context)
    {
        $currentValue = $context->getVariableValue($this->name);
        if ($this->preserve && $currentValue) {
            return;
        }

        $val = $this->expr->evaluate($context);
        $context->setVariableValue($this->name, $val);
    }
}