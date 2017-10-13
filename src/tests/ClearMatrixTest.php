<?php

use CampoMinado\Matrix;
use CampoMinado\ClearMatrix;

class ClearMatrixTest extends PHPUnit_Framework_TestCase
{
	public function testClearMatrix()
	{
		$matrix = new Matrix();
		$clear  = new ClearMatrix();

		$list = $matrix->generate(4, 4);
		$clear->cleaning($list, 1, 0);
	}
}