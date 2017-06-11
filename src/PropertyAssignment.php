<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class PropertyAssignment implements Expression
{
    const OVERRIDE_DEFAULT = 'default';
    const OVERRIDE_NON_EMPTY = 'non-empty';
    const OVERRIDE_ANY = 'any';

    /**
     * @var string
     */
    private $override;
    /**
     * @var Expression
     */
    private $expr;
    /**
     * @var
     */
    private $name;

    /**
     * PropertyAssignment constructor.
     * @param $name
     * @param Expression $expr
     * @param string $override
     * @internal param string $name
     */
    public function __construct($name, Expression $expr, $override)
    {
        $this->override = $override;
        $this->expr = $expr;
        $this->name = $name;
    }

    public static function parse($string)
    {
        preg_match('#([a-z_]+)([!]{0,2}):(.+)#', $string, $matches);
        if (!$matches) {
            throw new ParserException(sprintf('String "%s" is not valid property assignment', $string));
        }
        $name = $matches[1];
        $ems = $matches[2];
        $exprString = $matches[3];

        $override = PropertyAssignment::OVERRIDE_DEFAULT;
        if (count($ems) === 2) {
            $override = PropertyAssignment::OVERRIDE_ANY;
        } else if (count($ems) === 1) {
            $override = PropertyAssignment::OVERRIDE_NON_EMPTY;
        }

        return new PropertyAssignment($name, ExpressionParser::parseExpression($exprString), $override);
    }

    /**
     * @param $context
     * @return mixed
     */
    public function evaluate($context)
    {
        $currentValue = $context->getProp($this->name);
        if (!$currentValue) {
            $val = $this->expr->evaluate($context);
            $context->setProp($this->name, $val);
        }
        else if ($this->override === self::OVERRIDE_ANY) {
            $val = $this->expr->evaluate($context);
            $context->setProp($this->name, $val);
        }
        else if ($this->override === self::OVERRIDE_NON_EMPTY && $val = $this->expr->evaluate($context)) {
            $context->setProp($this->name, $val);
        }
    }
}