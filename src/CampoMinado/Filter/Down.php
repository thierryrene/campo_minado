<?php 

namespace CampoMinado\Filter;

use CampoMinado\Matrix;

class Down 
{
	public function filter(array $matrix, array $select, array $radio): array 
	{
		$line = $radio['row'];

		for ($line; $line > $select['row']; $line--) {
			
			if (!isset($matrix[$line])) continue;
			
			if ($select['column'] > $radio['column']) {

				$response = $this->smallColumn($matrix, $line, $select['column'], $radio['column']);
				$matrix   = $response['matrix'];

				if (!$response['success']) break;

				continue;

			}

			$response = $this->largeColumn($matrix, $line, $select['column'], $radio['column']);
			$matrix   = $response['matrix'];

			if (!$response['success']) break;

		}

		return $matrix;
	}

	private function largeColumn(array $matrix, int $line, int $column, int $limit): array
	{
		$success = true;
		for ($column; $column < $limit; $column++) {

			if ($column < 0) continue;
			
			if (isset($matrix[$line][$column]) && $matrix[$line][$column] != Matrix::BOMB) {
			
				$matrix[$line][$column] = MATRIX::CLEAR;
				continue;
			
			}
			
			$success = false;
			break;

		}
		
		return [
			'success' => $success, 
			'matrix'  => $matrix
		];
	}

	private function smallColumn(array $matrix, int $line, int $column, int $limit): array
	{
		$success = true;
		for ($column; $column > $limit; $column--) {

			if ($column < 0) continue;
			
			if (isset($matrix[$line][$column]) && $matrix[$line][$column] != Matrix::BOMB) {
			
				$matrix[$line][$column] = MATRIX::CLEAR;
				continue;
			
			}
			
			$success = false;
			break;
		}
		
		return [
			'success' => $success, 
			'matrix'  => $matrix
		];
	}
}