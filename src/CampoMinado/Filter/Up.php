<?php 

namespace CampoMinado\Filter;

use CampoMinado\Matrix;

class Up 
{
	public function filter(array $matrix, array $select, array $radio): array 
	{
		$line = $radio['row'];
		
		for ($line; $line < $select['row']; $line++) {

			if (!isset($matrix[$line])) continue;

			if ($select['column'] > $radio['column']) {

				$matrix = $this->smallColumn($matrix, $line, $select['column'], $radio['column']);
				continue;

			}

			$matrix = $this->largeColumn($matrix, $line, $select['column'], $radio['column']);

		}

		return $matrix;
	}

	private function largeColumn(array $matrix, int $line, int $column, int $limit): array
	{
		for ($column; $column <= $limit; $column++) {

			if ($column < 0) continue;
			
			if (isset($matrix[$line][$column]) && $matrix[$line][$column] != Matrix::BOMB) {
			
				$matrix[$line][$column] = MATRIX::CLEAR;
				continue;
			
			}		
			
			break;
		}
		
		return $matrix;
	}

	private function smallColumn(array $matrix, int $line, int $limit, int $column): array
	{
		for ($column; $column <= $limit; $column++) {

			if ($column < 0) continue;


			if (isset($matrix[$line][$column]) && $matrix[$line][$column] != Matrix::BOMB) {
			
				$matrix[$line][$column] = MATRIX::CLEAR;
				continue;
			
			}		
			
			break;
		}
		
		return $matrix;
	}
}