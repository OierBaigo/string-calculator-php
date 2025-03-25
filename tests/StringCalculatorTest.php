<?php

declare(strict_types=1);

namespace Deg540\StringCalculatorPHP\Test;

use Deg540\StringCalculatorPHP\StringCalculator;
use PHPUnit\Framework\TestCase;

final class StringCalculatorTest extends TestCase
{
    private StringCalculator $calculator;
    protected function setUp() : void
    {
        parent::setUp();
        $this->calculator = new StringCalculator();
    }

    /**
     * @test
     */
    public function givenVoidStringReturns0(): void
    {
        $this->assertEquals(0, $this->calculator->add(""));
    }

    /**
     * @test
     */
    public function given1NumberStringReturnsSameNumber(): void
    {
        $this->assertEquals(1, $this->calculator->add("1"));
    }

    /**
     * @test
     */
    public function given2NumbersStringReturnsNumbersSum(): void
    {
        $this->assertEquals(3, $this->calculator->add("1,2"));
    }

    /**
     * @test
     */
    public function givenMoreThan2NumbersStringReturnsNumbersSum(): void
    {
        $this->assertEquals(6, $this->calculator->add("1,2,3"));
    }

    /**
     * @test
     */
    public function givenMoreThan2NumbersStringReturnsNumbersSumWithLineBreak(): void
    {
        $this->assertEquals(6, $this->calculator->add("1,2\n3"));
    }

    /**
     * @test
     */
    public function givenDelimitersAndNumbersStringReturnsNumbersSum(): void
    {
        $this->assertEquals(6, $this->calculator->add("//[;]\n1;2;3"));
    }

    /**
     * @test
     */
    public function givenNegativeNumbersStringReturnsNegativeNumbersAndException(): void
    {
        $this->assertEquals("negativos no soportados: -1 -3", $this->calculator->add("//[;]\n-1;2;-3"));
    }

    /**
     * @test
     */
    public function givenNumberOver1000Ignore(): void
    {
        $this->assertEquals(1003, $this->calculator->add("//[;]\n1;2;1000;1001"));
    }

    /**
     * @test
     */
    public function givenDelimiterWithAnyLengthReturnsNumbersSum(): void
    {
        $this->assertEquals(6, $this->calculator->add("//[;;]\n1;;2;;3"));
    }

    /**
     * @test
     */
    public function givenMultipleDelimitersReturnsNumbersSum(): void
    {
        $this->assertEquals(6, $this->calculator->add("//[;;][:]\n1;;2:3"));
    }

    /**
     * @test
     */
    public function givenDelimiterWithAnyLengthWithDifferentCharactersReturnsNumbersSum(): void
    {
        $this->assertEquals(6, $this->calculator->add("//[;:]\n1;:2;:3"));
    }


}