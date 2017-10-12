<?php

namespace CampoMinado;

class ClearMatrix
{
	private $calcule;

	public function __construct()
	{
		$this->calcule = new CalculeMatrix();
	}

	public function cleaning(array $matrix, $line, $column)
	{
		$dimensions = $this->calcule->getDimensions($matrix, $line, $column);
		$matrix     = $this->search($matrix, $line, $column, $dimensions);

		die(var_dump($matrix));
	}

	private function search(array $matrix, $line, $column, array $dimensions)
	{
		$row = $dimensions['line'];

		foreach ($dimensions['column'] as $col) {
			$matrix = $this->up($matrix, $row['max'], $line, $column, $col);
			$matrix = $this->down($matrix, $row['min'], $line, $column, $col);
		}

		return $matrix;
	}

	private function up(array $matrix, $max, $line, $column, $col)
	{
		for ($line; $line <= $max; $line++) {

			if (!isset($matrix[$line])) continue;


			if ($col < $column) {

				for ($i=$col; $i < $column; $i++) {

					if (isset($matrix[$line][$i]) && $matrix[$line][$i] != 1) {
						$matrix[$line][$i] = null;
					}

				}

				continue;
			}

			for ($i=$column; $i < $col; $i++) {

				if (isset($matrix[$line][$i]) && $matrix[$line][$i] != 1) {
					$matrix[$line][$i] = null;
				}
			}

		}

		return $matrix;
	}

	private function down(array $matrix, $max, $line, $column, $col)
	{
		for ($line; $line >= $max; $line--) {

			if (!isset($matrix[$line])) continue;


			if ($col < $column) {

				for ($i=$col; $i < $column; $i++) {

					if (isset($matrix[$line][$i]) && $matrix[$line][$i] != 1) {
						$matrix[$line][$i] = null;
					}

				}

				continue;
			}

			for ($i=$column; $i < $col; $i++) {

				if (isset($matrix[$line][$i]) && $matrix[$line][$i] != 1) {
					$matrix[$line][$i] = null;
				}
			}

		}

		return $matrix;
	}

}