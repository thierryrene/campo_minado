<?php 

namespace CampoMinado\Filter;

interface Filter
{
	public function filter(array $matrix, array $select, array $radio): array;
}