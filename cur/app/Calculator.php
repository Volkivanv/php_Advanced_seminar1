<?php 
namespace App;
use Exception;
class Calculator
{
    public function add(...$args) 
     {
        return array_sum($args);
    }
}