<?php

use CampoMinado\CalculeMatrix;

class CalculeMatrixTest extends PHPUnit_Framework_TestCase
{
	public function testDimensions()
	{
		$math   = new CalculeMatrix();
		$matrix = range(1, 10);

		$dimesions = $math->getDimensions($matrix, 2, 6);
		$this->assertEquals(2, count($dimesions));
	}
}