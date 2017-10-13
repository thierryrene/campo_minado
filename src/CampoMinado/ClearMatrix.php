<?php

namespace CampoMinado;

use CampoMinado\Filter\Down;
use CampoMinado\Filter\Up;

class ClearMatrix
{
	private $calcule;
	private $down;
	private $up;

	public function __construct()
	{
		$this->calcule = new CalculeMatrix();
		$this->up      = new Up();
		$this->down    = new Down();
	}

	public function cleaning(array $matrix, int $line, int $column): array
	{		
		$dimensions = $this->calcule->getDimensions($matrix, $line, $column);
		$matrix     = $this->search($matrix, ['row' => $line, 'column' => $column], $dimensions);
		
		return $matrix;
	}

	private function search(array $matrix, array $native, array $dimensions): array
	{
		$row = $dimensions['line'];

		foreach ($dimensions['column'] as $col) {

			$matrix = $this->up->filter($matrix, ['column' => $col, 'row' => $row['max']], $native);
			$matrix = $this->down->filter($matrix, ['column' => $col, 'row' => $row['min']], $native);

		}

		return $matrix;
	}
}