<?php
namespace YevgenGrytsay\TelegramIvParser;

/**
 * @author: yevgen
 * @date: 11.06.17
 */
class TemplateParser
{
    /**
     * @var Context
     */
    private $ctx;

    /**
     * TemplateParser constructor.
     * @param Context $ctx
     */
    public function __construct(Context $ctx)
    {
        $this->ctx = $ctx;
    }

    public function parse(ParserIterator $it)
    {
        $ctx = $this->ctx;
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
                $stmt = new CompositeCondition($conditions);

                if (!$stmt->evaluate($ctx)) {
                    $it->skipUntil(Condition::class);
                }
            }
            else if ($stmt instanceof Comment) {
                $it->skip(Comment::class);
            }
            else if ($stmt instanceof Expression) {
                $stmt->evaluate($ctx);
            } else {
                throw new Exception('Unknown object');
            }
            $tree[] = $stmt;
        }

        return $tree;
    }
}