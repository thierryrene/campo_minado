<?php

session_start();

require_once '../testando_composer/vendor/autoload.php';    

$linhas  = 20;
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
			$vetorBombas[$a] = '';
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
				
				if (($l + 1) <= $linhas ) {
					if ($matrizComBombas[$l + 1][$c] != '@') {
						if ($matrizComBombas[$l + 1][$c] != 1) {
							$matrizComBombas[$l + 1][$c] = 1;
						}
					}
				}
				
				if (($c + 1) <= $colunas ) {
					if ($matrizComBombas[$l][$c + 1] != '@') {
						if ($matrizComBombas[$l][$c + 1] != 1) {
							$matrizComBombas[$l][$c + 1] = 1;
						}
					}
				}
				
				if (($l - 1) > 0 ) {
					if ($matrizComBombas[$l - 1][$c] != '@') {
						if ($matrizComBombas[$l - 1][$c] != 1) { 
							$matrizComBombas[$l - 1][$c] = 1;
						}
					}
				}
				
				if (($c - 1) > 0 ) {
					if ($matrizComBombas[$l][$c - 1] != '@') {
						if ($matrizComBombas[$l][$c - 1] != 1) { 
							$matrizComBombas[$l][$c - 1] = 1;
						} 
					}
				}
				
			}
			
		}
	}
	
	r($matrizComBombas);

	$_SESSION['matrizComBombas'] = $matrizComBombas;

} else {

	$matrizComBombas = $_SESSION['matrizComBombas'];
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mines!</title>

	<style type="text/css">		
		* {
			font-family: arial;
		}

		td {
			padding: 20px;
			background-color: gold;

		}
	</style>
</head>
<body>

	<div style="text-align: center;">
		<!-- <h1>Mine</h1> -->
		<hr>
	</div>

	<div style="margin:auto;">
		<a href="mine_rebuild.php">NEW GAME</a>
		<table style="margin: auto;">
			
			<?php

				foreach ($matrizComBombas as $l => $linha) {
					echo "<tr>";
						foreach($linha as $c => $coluna) {
							if ($coluna == '') {
								echo "<td style='background-color:grey;' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$l}&coluna={$c}\"'></td>";
							} elseif ($coluna == '@') {
								echo "<td style='background-color:crimson;' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$l}&coluna={$c}\"'>{$coluna}</td>";
							} else {
								echo "<td onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$l}&coluna={$c}\"'>{$coluna}</td>";
							}
						}
					echo "</tr>";
				}
				
				if (!empty($matrizComBombas) && $acao == 'click') {
					echo "<span style='color:snow; padding: 5px 8px; background-color: grey;'>você clicou na linha {$_REQUEST['linha']}, coluna {$_REQUEST['coluna']}</span>";
				}
				
				

			?>

		</table>

	</div>

	
</body>
</html>


<?php

r($matrizComBombas);


// for ($linha = 1; $linha <= $linhas; $linha++) {
// 	echo "<tr>";
// 		for ($coluna = 1; $coluna <= $colunas; $coluna++) {
// 			echo "<td style='background-color: gray;' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$linha}&coluna={$coluna}\"'></td>";
// 		}
// 	echo "</tr>";
// }
?>