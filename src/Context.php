<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
interface Context
{
    /**
     * @param string $expr
     * @param DOMNode|null $context
     * @return DOMNodeList
     */
    public function findXpath($expr, \DOMNode $context = null);

    /**
     * @param string $name
     * @return mixed
     */
    public function getProp($name);

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setProp($name, $value);

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function getVariableValue($name);

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setVariableValue($name, $value);

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function getValue($name);

    /**
     * @param string $name
     * @return \DOMElement
     */
    public function createElement($name);
}