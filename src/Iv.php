<?php
/**
 * @author: yevgen
 * @date: 10.06.17
 */
require_once __DIR__.'/../vendor/autoload.php';

// 1. Load grammar.
$compiler = Hoa\Compiler\Llk\Llk::load(new Hoa\File\Read('Iv.pp'));

// 2. Parse a data.
$template = '
?domain: .+\.abc\.com
?domain: .+\.abc\.com
!path: /news/
';

$lines = explode("\n", $template);
$dump = new Hoa\Compiler\Visitor\Dump();
foreach ($lines as $line) {
    if (!$line) {
        continue;
    }
    $ast = $compiler->parse($line);
    echo $dump->visit($ast), PHP_EOL;
}
