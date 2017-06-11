<?php
/**
 * @author: yevgen
 * @date: 11.06.17
 */
require_once __DIR__ . '/../vendor/autoload.php';

// 1. Load grammar.
$compiler = Hoa\Compiler\Llk\Llk::load(new Hoa\File\Read('alnum.pp'));


$template = "body\n?hello\n?world";

$dump = new Hoa\Compiler\Visitor\Dump();
$ast = $compiler->parse($template);
echo $dump->visit($ast), PHP_EOL;
