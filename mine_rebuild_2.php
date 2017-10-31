<?php

if (!isset($_SESSION)) {
	session_start();
}

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	require_once '../composer/vendor/autoload.php';    
}

$linhas  = 5;
$colunas = $linhas;
$bombas = 3;
$bomba = '@';
$totalCelulas = $linhas * $colunas;

// valores url que vamos utilizar para manipular o programa através da URL
$acao 			= !empty($_REQUEST['acao']) 	? $_REQUEST['acao'] 	: null;
$clickLinha 	= !empty($_REQUEST['linha']) 	? $_REQUEST['linha'] 	: null;
$clickColuna 	= !empty($_REQUEST['coluna']) 	? $_REQUEST['coluna'] 	: null;
$cell 			= !empty($_REQUEST['celula'])	? $_REQUEST['celula'] 	: null;
$emptyBlock		= !empty($_REQUEST['empty'])	? $_REQUEST['empty']	: null;

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
				
				// gambs para setar valor das células como null
				if ($matrizComBombas[$l][$c] == 0) {
					$matrizComBombas[$l][$c] = null;
				}

			}		
			
		}
	}

	$_SESSION['matrizComBombas'] = $matrizComBombas;

} else {

	$matrizComBombas = $_SESSION['matrizComBombas'];

	// capturamos o valor do click				
	$clickMouse = $matrizComBombas[$clickLinha][$clickColuna];

	// condição que encerra jogo aoclicar na bomba
	$clickBomba = ($clickMouse == $bomba && $acao ? true : false);	

	// marcamos o bloco clicado com 'x' se ação estiver setada e o bloco for direfente de bomba
	if ($matrizComBombas[$clickLinha][$clickColuna] == null) {
		$matrizComBombas[$clickLinha][$clickColuna] = 'x';
		$_SESSION['matrizComBombas'] = $matrizComBombas;	
	} elseif ($matrizComBombas[$clickLinha][$clickColuna] != $bomba) {
		$matrizComBombas[$clickLinha][$clickColuna] = $matrizComBombas[$clickLinha][$clickColuna];
		$_SESSION['matrizComBombas'] = $matrizComBombas;				
	}						

	if ($matrizComBombas[$clickLinha][$clickColuna] == null || $matrizComBombas[$clickLinha][$clickColuna] != $bomba) {
		echo "<script>console.log('clickMouse: {$matrizComBombas[$clickLinha][$clickColuna]}.');</script>";
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
		}
	</style>
</head>
<body>

	<div style="text-align: center;">
		<!-- <h1>Mines!</h1>				 -->
	</div>

	<div style="margin:auto;" align="center">

		<div style="text-align: center;">
			<br>
			<br>	
			<a href="mine_rebuild_2.php" style="padding: 8px 12px; background-color: green; color: snow; border: #424242 solid 1px; text-decoration: none;">NEW</a>
			<!-- <a href="mine_rebuild_2.php?destroy=1" style="padding: 8px 12px; background-color: crimson; color: snow; border: #424242 solid 1px; text-decoration: none;">DESTROY SESSION</a> -->
			<br>
			<br>
		</div>

		<table style="margin: auto;" border="1">
			
			<?php

				

				// contador da vitória
				$contadorDaVitoria = 0;		

				// matriz apresentada no front
				foreach ($matrizComBombas as $l => $linha) {

					echo "<tr>";

						 foreach ($linha as $c => $coluna) {

						 	// contador de blocos nulos
						 	if ($coluna == null && $coluna != $bomba) {
						 		$contadorDaVitoria++;
						 		$fim = ($contadorDaVitoria <= 0 ? true : false);
						 	}		

							if (!$acao) {
						 		$tdColor = 'grey';
								$text = 0;
						 	} else {
						 		
						 		// if ($coluna == 'x') {
						 		// 	$tdColor = 'transparent';
						 		// 	$coluna = '';
						 		// } elseif ( gettype($coluna) == 1 && $coluna != $bomba ) {
						 		// 	$tdColor = 'transparent';
						 		// 	$text = '10px';
						 		// } else {
						 		// 	$tdColor = 'grey';
						 		// 	$text = 0;
						 		// }
						 		
						 		if ($coluna == 'x') {
						 			$tdColor = 'transparent';
						 			$coluna = '';
						 		} elseif ($coluna != null && $coluna <= $bombas && $coluna != $bomba) {
						 			$tdColor = 'transparent';
						 			$text = '10px';
						 		} else {
						 			$tdColor = 'grey';
						 			$text = 0;
						 		}						 		

							 	if ($clickBomba || $fim) {
						 			$tdColor = 'transparent';
						 			$text = '10px';
							 	}

						 	}	

						 	echo "<td style='background-color: {$tdColor};font-size: {$text};' onclick='javascript: window.location=\"mine_rebuild_2.php?acao=click&linha={$l}&coluna={$c}\"';'>{$coluna}</td>";	

						}

					echo "</tr>";

				}			

				// mensagem WINNER or LOSER
				if ($clickBomba) {
					echo "<h3 align='center' style='color: crimson;'>¯\_(ツ)_/¯</h3>
						  <h3 align='center' style='color: crimson;'>YOU LOSE!</h3>";
				} elseif ($fim) {
					echo "<h3 align='center' style='color: green;'>YOU WIN!</h3>";
				}				
				
			?>

		</table>

	</div>	
	
</body>
</html>

<?php

// DEBUG
if ($acao) {
	echo "<script>console.log('Você clicou na linha {$clickLinha}, coluna {$clickColuna}');</script>";
}

if ($_REQUEST['destroy'] == 1) {	
	unset($fim);
	echo "<h3 align='center'>SESSION DESTROYED!</h3>";
	session_destroy();
}

r($matrizComBombas, $clickBomba, $fim);

?>


