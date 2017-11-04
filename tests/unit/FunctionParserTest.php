<?php
/**
 * @author: yevgen
 * @date  : 17.06.17
 */

use PHPUnit\Framework\TestCase;
use YevgenGrytsay\TelegramIvParser\ExpressionParser;

class FunctionParserTest extends TestCase
{
    /**
     * @dataProvider getData
     */
    public function testParse($callStr, $expected)
    {
        $actual = ExpressionParser::parseFunctionCall($callStr);
        $this->assertEquals($expected, $actual);
    }

    public function getData()
    {
        return [
            [
                '@replace("goodb", "B", "i"): //p/text()',
                ['replace', ['"goodb"', '"B"', '"i"'], '//p/text()']
            ],
            [
                '@urlencode: $a/@href',
                ['urlencode', [], '$a/@href']
            ],
            [
                '@debug', ['debug', [], '']
            ],
            [
                '@debug: //article//a',
                ['debug', [], '//article//a']
            ],
        ];
    }
}
