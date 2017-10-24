<?php

session_start();

require_once '../composer/vendor/autoload.php';    

$linhas  = 10;
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
$emptyBlock		= !empty($_REQUEST['bloco'])	? $_REQUEST['bloco'] 	: null;

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

	// utilizamos um contador das bombas para determinar o indice que deve ser inserido na matriz com bombas
	$contadorBombas = 1;

	// distribuimos os valores do vetor na matriz
	for ($l = 1; $l <= $linhas; $l++) {
		for ($c = 1; $c <= $colunas; $c++) {
			$matrizComBombas[$l][$c] = $vetorBombas[$contadorBombas];
			$contadorBombas++;
		}
	}

	// contador de bombas em volta dos blocos
	$bombaContador = 0;

	foreach($matrizComBombas as $l => $linha) {

		foreach ($linha as $c => $coluna) {

			// verificamos em volta dos blocos vazios
			if ($coluna == '') {	

				// bloco de cima
				if (isset($matrizComBombas[$l + 1][$c])) {
					if ($matrizComBombas[$l + 1][$c] == $bomba) {
						$bombaContador++;							
					}
				}

				// bloco diagonal superior direita
				if (isset($matrizComBombas[$l - 1][$c + 1])) {
					if ($matrizComBombas[$l - 1][$c + 1] == $bomba) {
						$bombaContador++;
					}
				}

				// bloco da frente
				if (isset($matrizComBombas[$l][$c + 1])) {
					if ($matrizComBombas[$l][$c + 1] == $bomba) {
						$bombaContador++;						
					}
				}

				// bloco diagonal inferior direito
				if (isset($matrizComBombas[$l + 1][$c + 1])) {
					if ($matrizComBombas[$l + 1][$c + 1] == $bomba) {
						$bombaContador++;
					}
				}

				// bloco de baixo
				if (isset($matrizComBombas[$l - 1][$c])) {
					if ($matrizComBombas[$l - 1][$c] == $bomba) {
						$bombaContador++;
					}
				}

				// bloco diagonal inferior esquerdo
				if (isset($matrizComBombas[$l + 1][$c - 1])) {
					if ($matrizComBombas[$l + 1][$c - 1] == $bomba) {
						$bombaContador++;
					}
				}		

				// bloco de trás
				if (isset($matrizComBombas[$l][$c - 1])) {
					if ($matrizComBombas[$l][$c - 1] == $bomba) {
						$bombaContador++;
					}
				}		

				// bloco diagonal superior esquerdo 
				if (isset($matrizComBombas[$l - 1][$c - 1])) {
					if ($matrizComBombas[$l - 1][$c - 1] == $bomba) {
						$bombaContador++;
					}
				}
				
				$matrizComBombas[$l][$c] = $bombaContador;	

				$bombaContador = 0;									
				
				if ($matrizComBombas[$l][$c] == 0) {
					$matrizComBombas[$l][$c] = null;
				}

			}		
			
		}
	}

	$_SESSION['matrizComBombas'] = $matrizComBombas;

} else {

	$matrizComBombas = $_SESSION['matrizComBombas'];

	$clickMouse = $matrizComBombas[$clickLinha][$clickColuna];

	// condição para apagar blocos
	if ($emptyBlock != '' && $acao != '') {
		echo "<script>console.log('condição para apagar blocos OK');</script>";
	}

	if ($clickMouse == $bomba) {
		echo $bomba;
		echo "<p>Você clicou em uma bomba. Jogo encerrado. :(</p>";
		echo "<a href='mine_rebuild.php'>NEW GAME</a>";
		die;
	}
	
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

							if ($coluna == null) {
								echo "<td style='background-color:grey;' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$l}&coluna={$c}&bloco=empty\"'></td>";
							} elseif ($coluna == $bomba) {
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

?>