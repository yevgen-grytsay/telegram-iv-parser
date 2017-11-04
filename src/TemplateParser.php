<?php
namespace YevgenGrytsay\TelegramIvParser;

use YevgenGrytsay\TelegramIvParser\Expression\CompositeCondition;
use YevgenGrytsay\TelegramIvParser\Expression\Condition;
use YevgenGrytsay\TelegramIvParser\Statement\ConditionalBlock;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class TemplateParser
{
    /**
     * @param ParserIterator $it
     * @return array
     * @throws \Exception
     */
    public function parse(ParserIterator $it)
    {

        $tree = [];
        while ($stmt = $it->next()) {
            if (!$stmt) {
                continue;
            }
            if ($stmt === "\0") {
                break;
            }
            if ($stmt instanceof Condition) {
                $conditions = $it->collect(Condition::class);
                array_unshift($conditions, $stmt);

                $statements = $it->collectNot([Condition::class]);
                $tree[] = new ConditionalBlock(new CompositeCondition($conditions), $statements);
            }
            else if ($stmt instanceof Comment) {
                $it->skip(Comment::class);
            }
            else if ($stmt instanceof Statement) {
                $tree[] = $stmt;
            } else {
                throw new \Exception('Unknown object');
            }
        }

        return $tree;
    }
}