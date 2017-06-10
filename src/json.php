<?php
/**
 * @author: yevgen
 * @date: 10.06.17
 */
require_once __DIR__.'/../vendor/autoload.php';

// 1. Load grammar.
$compiler = Hoa\Compiler\Llk\Llk::load(new Hoa\File\Read('JsonGrammar.pp'));

// 2. Parse a data.
$ast = $compiler->parse('{"foo": true, "bar": [null, 42]}');

// 3. Dump the AST.
$dump = new Hoa\Compiler\Visitor\Dump();
echo $dump->visit($ast);