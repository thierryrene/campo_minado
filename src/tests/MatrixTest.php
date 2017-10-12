<?php

use CampoMinado\Matrix;

class MatrixTest extends PHPUnit_Framework_TestCase
{
	public function testMatrix()
	{
		$matrix_generate = new Matrix();
		$matrix          = $matrix_generate->generate(10, 2);
		$mine            = 0;

		foreach ($matrix as $line) {

			foreach ($line as $row) {
			 	if ($row) $mine++;
			}

		}

		$this->assertEquals(10, count($matrix));
		$this->assertEquals(2, $mine);
	}
}