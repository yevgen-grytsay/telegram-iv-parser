<?php
/**
 * @author: yevgen
 * @date: 11.06.17
 */

use PHPUnit\Framework\TestCase;

class ExtractionTest extends TestCase
{
    public function testExtraction()
    {
        $lines = [
            'body: //article',
            '<figure>: $body/div[has-class("image")]'
        ];

        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        $html = file_get_contents(__DIR__ . '/../test_1_in.html');
        @$doc->loadHTML($html);
        $ctx = new DomContext($doc);
        $pi = new ParserIterator($lines, new LineParser());
        $tp = new TemplateParser($ctx);
        $tp->parse($pi);

        $body = $ctx->getProp('body');
        $actualHtml = $doc->saveHTML($body);
        $this->assertStringEqualsFile(__DIR__.'/../test_1_out.html', $actualHtml);


        $this->assertStringEqualsFile(__DIR__.'/../test_1_full_out.html', $doc->saveHTML());
    }
}
