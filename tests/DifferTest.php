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
        $test1content = file_get_contents(__DIR__  . "/fixtures/TestResult1.txt");
        $t1path1 = "files/file1.json";
        $t1path2 = "files/file2.json";
        $this->assertEquals($test1content, gendiff($t1path1, $t1path2, 'stylish'));

        $test2content = file_get_contents(__DIR__  . "/fixtures/TestResult2.txt");
        $t1path3 = "files/file3.yaml";
        $t1path4 = "files/file4.yaml";
        $this->assertEquals($test2content, gendiff($t1path3, $t1path4, 'stylish'));

        $test3content = file_get_contents(__DIR__  . "/fixtures/TestResult3.txt");
        $t1path5 = "files/file5.json";
        $t1path6 = "files/file6.json";
        $this->assertEquals($test3content, gendiff($t1path5, $t1path6, 'stylish'));
    }
}
