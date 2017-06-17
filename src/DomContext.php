<?php
namespace YevgenGrytsay\TelegramIvParser;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class DomContext implements Context
{
    /**
     * @var \DOMDocument
     */
    private $doc;
    /**
     * @var \DOMXPath
     */
    private $xpath;
    /**
     * @var array
     */
    private $props = [];
    /**
     * @var array
     */
    private $vars = [];

    /**
     * DomContext constructor.
     * @param \DOMDocument $doc
     */
    public function __construct(\DOMDocument $doc)
    {
        $this->doc = $doc;
        $this->xpath = new \DOMXPath($doc);
    }

    /**
     * @param string $expr
     * @param \DOMNode|null $context
     * @return \DOMNodeList
     */
    public function findXpath($expr, \DOMNode $context = null)
    {
        return $this->xpath->query($expr, $context);
    }

    public function getProp($name)
    {
        return $this->props[$name] ?? null;
    }

    public function setProp($name, $value)
    {
        $this->props[$name] = $value;
    }

    private function existsProp($name)
    {
        return array_key_exists($name, $this->props);
    }

    public function getValue($name)
    {
        if ($this->existsProp($name)) {
            return $this->getProp($name);
        }
        if (array_key_exists($name, $this->vars)) {
            return $this->vars[$name];
        }
        return null;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function getVariableValue($name)
    {
        $this->ensureVariableDeclared($name);
        return $this->vars[$name];
    }

    /**
     * @param $name
     * @throws \Exception
     */
    private function ensureVariableDeclared($name)
    {
        if (!array_key_exists($name, $this->vars)) {
            throw new \Exception(sprintf('Variable "%s" is not decalred', $name));
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setVariableValue($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * @param string $name
     * @return \DOMElement
     */
    public function createElement($name)
    {
        return $this->doc->createElement($name);
    }
}