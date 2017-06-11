<?php
/**
 * @author: yevgen
 * @date: 11.06.17
 */
require_once __DIR__.'/../vendor/autoload.php';

$raw = file_get_contents(__DIR__ . '/sample.ivt');
$lines = preg_split('#\n#', $raw);

var_dump($raw);

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="UTF-8">' . file_get_contents(__DIR__.'/medium_1.html'));
$ctx = new DomContext($doc);
$pi = new ParserIterator($lines, new LineParser());
$tp = new TemplateParser($ctx);
$tree = $tp->parse($pi);

var_dump($tree);

//$emptyLine = new stdClass();
//$comment = new stdClass();
//$prev = null;
//foreach ($lines as $line) {
//    if (!trim($line)) {
//        $prev = $emptyLine;
//        continue;
//    }
//    if ($line[0] === ' ' && $prev === $comment) {
//        continue;
//    }
//
//    switch ($line[0]) {
//        case '@':
//            // function call
//            break;
//        case '$':
//            //variable assignment
//            break;
//        case '<':
//            //tag
//            break;
//        default:
//    }
//}