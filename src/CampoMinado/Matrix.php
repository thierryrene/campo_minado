<?php

namespace CampoMinado;

use Exception;

class Matrix
{
	const BOMB  = 'bomb';
	const CLEAR = 'clear';
	const HIDE  = 'hide';


	public function generate($lines, $bombs)
	{
		if ($bombs <= 0 || $lines <= 0) {
			throw new Exception('Os valores precisam ser maiores que zero', 1);
		}

		$matrix = $this->makeLines($lines);
		$matrix = $this->addBombs($matrix, $bombs);

		return $matrix;
	}

	private function addBombs($matrix, $bombs)
	{
		$total = 0;
		$max   = count($matrix) - 1;

		do {

			$column = mt_rand(0, $max);
			$line   = mt_rand(0, $max);

			if ($matrix[$column][$line] == self::HIDE) {

				$matrix[$column][$line] = self::BOMB;
				$total++;

			}

		} while ($total < $bombs);

		return $matrix;
	}

	private function makeLines($lines)
	{
		$matrix = [];

		for ($c=0; $c < $lines; $c++) {

			if (empty($matrix[$c])) $matrix[$c] = [];

			for ($l=0; $l < $lines; $l++) {
				$matrix[$c][$l] = self::HIDE;
			}

		}

		return $matrix;
	}
}