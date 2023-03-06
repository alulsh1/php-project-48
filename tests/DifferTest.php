<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

// ����� UtilsTest ��������� ����� TestCase
// ��� ������ ��������� � ������ �����
class DifferTest extends TestCase
{
    public function testReverse(): void
    {
        $test1content = file_get_contents(__DIR__  . "/fixtures/TestResult1.txt");
        $t1path1 = "file1.json";
        $t1path2 = "file2.json";
        $this->assertEquals($test1content, gendiff($t1path1, $t1path2));
    }
}
