<?php

namespace CampoMinado;

class CalculeMatrix
{
	public function getDimensions(array $matrix, $line, $column)
	{
		$total             = count($matrix);
		$column_dimensions = $this->calcule($total, $column);
		$line_dimensions   = $this->calcule($total, $line);

		return [
			'line'   => $line_dimensions,
			'column' => $column_dimensions
		];
	}

	private function calcule($total, $value)
	{
		$middle = (int) floor( $total / 2 ) - 1;

		$max = $value + $middle;
		$min = $value - $middle;

		return compact('min', 'max');
	}
}