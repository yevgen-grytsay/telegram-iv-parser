<?php
/**
 * @author: yevgen
 * @date: 11.06.17
 */

use PHPUnit\Framework\TestCase;

class ParserIteratorTest extends TestCase
{
    public function testCollect()
    {
        $lineParser = $this->createMock(LineParser::class);
        $mocks = [
            $this->createMock(Condition::class),
            $this->createMock(Condition::class),
            $this->createMock(Condition::class),
            $this->createMock(Comment::class)
        ];
        $lineParser->method('parse')->willReturnOnConsecutiveCalls($mocks[0], $mocks[1], $mocks[2], $mocks[3]);

        $pi = new ParserIterator(['', '', ''], $lineParser);
        $conditions = array_merge([$pi->next()], $pi->collect(Condition::class));

        $this->assertEquals(array_slice($mocks, 0, count($mocks) - 1), $conditions);
        $this->assertSame($mocks[3], $pi->next());
        $this->assertEquals("\0", $pi->next());
    }

    public function testSkip()
    {
        $lineParser = $this->createMock(LineParser::class);
        $mocks = [
            $this->createMock(Condition::class),
            $this->createMock(Comment::class),
            $this->createMock(Condition::class),
        ];
        $lineParser->method('parse')->willReturnOnConsecutiveCalls($mocks[0], $mocks[1], $mocks[2], $mocks[2]);
        $pi = new ParserIterator(['', '', ''], $lineParser);

        $firstCond = $pi->next();
        $pi->skipUntil(Condition::class);

        $this->assertEquals([$mocks[0], $mocks[2]], [$firstCond, $pi->next()]);
        $this->assertEquals("\0", $pi->next());
    }
}
