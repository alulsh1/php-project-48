<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

// класс UtilsTest наследует класс TestCase
// имя класса совпадает с именем файла
class DifferTest extends TestCase
{
    public function testReverse(): void
    {
        $this->assertEquals('{"- follow":false,"+ 
		follow":true,"host":"hexlet.io","- proxy":"123.234.53.22","- 
		timeout":50,"+ timeout":20,"+ verbose":true}', gendiff('file1.json', 'file2.json'));
    }
}
