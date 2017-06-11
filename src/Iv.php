<?php
/**
 * @author: yevgen
 * @date: 10.06.17
 */
require_once __DIR__.'/../vendor/autoload.php';

// 1. Load grammar.
$compiler = Hoa\Compiler\Llk\Llk::load(new Hoa\File\Read('Iv.pp'));

// 2. Parse a data.
$template = '?exists: /html/head/meta[@property="article:published_time"]
?true
body: //article';
//$template = 'body';

$dump = new Hoa\Compiler\Visitor\Dump();
$ast = $compiler->parse($template);
echo $dump->visit($ast), PHP_EOL;
