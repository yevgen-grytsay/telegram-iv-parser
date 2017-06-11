<?php

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class ParserIterator
{
    /**
     * @var array
     */
    private $input;
    /**
     * @var LineParser
     */
    private $lineParser;
    /**
     * @var int
     */
    private $i = -1;

    /**
     * ParserIterator constructor.
     * @param array $input
     * @param LineParser $lineParser
     */
    public function __construct(array $input, LineParser $lineParser)
    {
        $this->input = $input;
        $this->lineParser = $lineParser;
    }

    public function next()
    {
        if (array_key_exists($this->i + 1, $this->input)) {
            $prev = $this->i >= 0 ? $this->input[$this->i] : null;
            $maxIndex = count($this->input) - 1;
            $stmt = null;
            while ($this->i < $maxIndex && !($stmt = $this->lineParser->parse($this->input[++$this->i]))) {
            }

            return $stmt;
//            if ($stmt->canBeMultiline()) {
            //todo: implement
//            }
        }
        return "\0";
    }

    public function collect($className)
    {
        $result = [];
        while ($stmt = $this->next()) {
            if ($stmt instanceof $className) {
                $result[] = $stmt;
            } else {
                $this->i--;
                break;
            }
        }

        return $result;
    }

    public function skip($className)
    {
        while ($stmt = $this->next()) {
            if (!$stmt instanceof $className) {
                $this->i--;
                break;
            }
        }
    }

    public function collectNot(array $classNames)
    {
        $match = function ($object) use($classNames) {
            foreach ($classNames as $name) {
                if ($object instanceof $name) {
                    return true;
                }
            }
            return false;
        };

        $result = [];
        while ($stmt = $this->next()) {
            if ($match($stmt)) {
                $this->i--;
                break;
            }
            $result[] = $stmt;
        }

        return $result;
    }

    public function skipUntil($className)
    {
        while ($stmt = $this->next()) {
            if ($stmt instanceof $className) {
                $this->i--;
                break;
            }
        }
    }
}