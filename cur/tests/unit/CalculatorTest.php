<?php 

namespace AppUnitTests;

use App\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @var Calculator
     */
    private $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->calculator = new Calculator();
    }

    public function testAdd(): void
    {
        $result = $this->calculator->add(2,3);

        self::assertEquals(5, $result);
    }
}