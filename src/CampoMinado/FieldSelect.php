<?php 

namespace CampoMinado;

class FieldSelect 
{
	private $clear;

	public function __construct()
	{
		$this->clear = new ClearMatrix();
	}


	public function try (array $matrix, int $line, int $column): array 
	{
		if (empty($matrix[$line][$column])) {
			throw new Exception('Você escolheu um campo inválido', 1);
		}

		if ($matrix[$line][$column] == Matrix::BOMB) {

			return [
				'success' => false,
				'message' => 'Acertou uma bomba :/',
				'matrix'  => $matrix
			];

		}

		$matrix = $this->clear->cleaning($matrix, $line, $column);

		return [
			'success' => true,
			'message' => 'Acertou um Campo livre :)',
			'matrix'  => $matrix
		];

	}
}