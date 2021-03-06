<?php
/**
 * @author: yevgen
 * @date: 11.06.17
 */
require_once __DIR__.'/../vendor/autoload.php';

$raw = file_get_contents(__DIR__ . '/sample.ivt');
$lines = preg_split('#\n#', $raw);

var_dump($raw);

$pi = new \YevgenGrytsay\TelegramIvParser\ParserIterator($lines, new \YevgenGrytsay\TelegramIvParser\LineParser());
$tp = new \YevgenGrytsay\TelegramIvParser\TemplateParser();
$tree = $tp->parse($pi);

array_walk($tree, function ($stmt) {
    echo $stmt, PHP_EOL;
});
//var_dump($tree);

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