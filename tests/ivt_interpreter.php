<?php
/**
 * @author: yevgen
 * @date: 11.06.17
 */
require_once __DIR__.'/../vendor/autoload.php';

$raw = file_get_contents(__DIR__ . '/sample.ivt');
$lines = preg_split('#\n#', $raw);

var_dump($raw);

$doc = new \DOMDocument();
@$doc->loadHTML('<?xml encoding="UTF-8">' . file_get_contents(__DIR__.'/medium_1.html'));
$ctx = new \YevgenGrytsay\TelegramIvParser\DomContext($doc);
$pi = new \YevgenGrytsay\TelegramIvParser\ParserIterator($lines, new \YevgenGrytsay\TelegramIvParser\LineParser());
$tp = new \YevgenGrytsay\TelegramIvParser\TemplateInterpreter($ctx);
$tp->parse($pi);
/** @var \DOMElement $el */
$el = $ctx->getProp('body');
echo $el->ownerDocument->saveHTML($el);