<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    require_once '../composer/vendor/autoload.php';    
}

$linhas  = 8;
// colunas com o mesmo valor das linhas
$colunas = $linhas;
$bombas = 10;
$bomba = '@';
$totalCelulas = $linhas * $colunas;

// valores url que vamos utilizar para manipular o programa através da URL
$acao 			= !empty($_REQUEST['acao']) 	? $_REQUEST['acao'] 	: null;
$clickLinha 	= !empty($_REQUEST['linha']) 	? $_REQUEST['linha'] 	: null;
$clickColuna 	= !empty($_REQUEST['coluna']) 	? $_REQUEST['coluna'] 	: null;
$cell 			= !empty($_REQUEST['celula'])	? $_REQUEST['celula'] 	: null;

$contadorCelulas = 1;

if($acao != 'click') {

	$matrizInicial = array();				

	// contador utilizado para contar o número de células dentro da matriz
	$contadorCelulas = 0;

	// criamos a matriz na variável $matrizInicial
	for ($linha = 1; $linha <= $linhas; $linha++) {
		for ($coluna = 1; $coluna <= $colunas; $coluna++) {
			$matrizInicial[$linha][$coluna] = null;
		}
	}

	// vamos utilizar esse array para armazenar e distribuir as bombas
	$vetorBombas = array();

	// distribuímos as bombas no vetor com mesma quantidade de valores da matriz (100 blocos)
	for ($a = 1; $a <= $totalCelulas; $a++) {
		if ($a <= $bombas) {
			$vetorBombas[$a] = $bomba;
		} else {
			$vetorBombas[$a] = null;
		}
	}

	// randomizamos os valores
	shuffle($vetorBombas);

	// criamos uma cópia da matriz inicial, para facilitar a leitura do código
	$matrizComBombas = $matrizInicial;

	// utilizamos um contador das bombas para determinar o indícel que deve ser inserido na matriz com bombas
	$contadorBombas = 0;

	// distribuimos os valores do vetor na matriz
	for ($l = 1; $l <= $linhas; $l++) {
		for ($c = 1; $c <= $colunas; $c++) {
			$matrizComBombas[$l][$c] = $vetorBombas[$contadorBombas];
			$contadorBombas++;
		}
	}

	foreach($matrizComBombas as $l => $linha) {
		foreach ($linha as $c => $coluna) {

			if ($coluna == '@') {
				
				// verificamos bloco acima
				if (($l + 1) = $linhas) {
					
				}

				// verificamos bloco da frente
				if (($c + 1) <= $colunas) {

				}

				// verificamos bloco de baixo
				if (($l - 1) <= $linhas) {

				} 

				// verificamos bloco de trás
				if (($c - 1) <= $colunas) {

				}

			}

		}
	}

	$_SESSION['matrizComBombas'] = $matrizComBombas;

} else {

	$matrizComBombas = $_SESSION['matrizComBombas'];

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mine!</title>

	<style type="text/css">		
		* {
			font-family: tahoma;
		}

		td {
			padding: 20px;

		}
	</style>
</head>
<body>

	<div style="text-align: center;">
		<!-- <h1>Mine</h1> -->
		<hr>
	</div>

	<div>
		
		<table style="margin: auto;" border="1">
			
			<?php

				foreach ($matrizComBombas as $l => $linha) {
					echo "<tr>";
						foreach($linha as $c => $coluna) {
							echo "<td>{$coluna}</td>";
						}
					echo "</tr>";
				}

			?>

		</table>

	</div>

	
</body>
</html>


<?php

r($GLOBALS);


// for ($linha = 1; $linha <= $linhas; $linha++) {
// 	echo "<tr>";
// 		for ($coluna = 1; $coluna <= $colunas; $coluna++) {
// 			echo "<td style='background-color: gray;' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$linha}&coluna={$coluna}\"'></td>";
// 		}
// 	echo "</tr>";
// }
?>