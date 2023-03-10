<?php

namespace Hexlet\Phpunit\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

// класс UtilsTest наследует класс TestCase
// имя класса совпадает с именем файла
class DifferTest extends TestCase
{
    public function testDifferStylish(): void
    {
        $test1content = file_get_contents(
            __DIR__ . "/fixtures/TestResult1.txt"
        );
        $t1path1 = "/fixtures/file1.json";
        $t1path2 = "/fixtures/file2.json";
        $this->assertEquals(
            $test1content,
            gendiff($t1path1, $t1path2, "stylish")
        );

        $test2content = file_get_contents(
            __DIR__ . "/fixtures/TestResult2.txt"
        );
        $t1path3 = "/fixtures/file3.yaml";
        $t1path4 = "/fixtures/file4.yaml";
        $this->assertEquals(
            $test2content,
            gendiff($t1path3, $t1path4, "stylish")
        );

        $test3content = file_get_contents(
            __DIR__ . "/fixtures/TestResult3.txt"
        );
        $t1path5 = "/fixtures/file5.json";
        $t1path6 = "/fixtures/file6.json";
        $this->assertEquals(
            $test3content,
            gendiff($t1path5, $t1path6, "stylish")
        );
    }
    public function testDifferNestedPlain(): void
    {
        $test4content = file_get_contents(
            __DIR__ . "/fixtures/TestResult4.txt"
        );
        $t1path5 = "/fixtures/file5.json";
        $t1path6 = "/fixtures/file6.json";
        $this->assertEquals(
            $test4content,
            gendiff($t1path5, $t1path6, "plain")
        );
    }
    public function testDifferNestedJson(): void
    {
        $test5content = file_get_contents(
            __DIR__ . "/fixtures/TestResult5.txt"
        );
        $t1path7 = "/fixtures/file5.json";
        $t1path8 = "/fixtures/file6.json";
        $this->assertEquals(
            $test5content,
            gendiff($t1path7, $t1path8, "json")
        );
    }
}
