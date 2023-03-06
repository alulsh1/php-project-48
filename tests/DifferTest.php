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
        $this->assertEquals($test1content, gendiff('file1.json', 'file2.json'));
    }
}
