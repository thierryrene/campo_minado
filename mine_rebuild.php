<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once '../composer/vendor/autoload.php';    

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

	// copia da matriz para marcar blocos
	$matrizMarcada = $matrizComBombas;

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
		<br>
		<!-- <h1>Mines!</h1>		 -->
		<a href="mine_rebuild.php" style="padding: 8px 12px; background-color: green; color: snow; border: #424242 solid 1px; text-decoration: none;">NEW</a>
		<br>
		<br>
		<br>
	</div>

	<div style="margin:auto;" align="center">

		<table style="margin: auto;" border="1">
			
			<?php

				// capturamos o valor do click
				$clickMouse = $matrizComBombas[$clickLinha][$clickColuna];

				// condição que encerra jogo se clicar na bomba
				if ($clickMouse == $bomba) {
					$clickBomba = true;
					echo "<h3>¯\_(ツ)_/¯</h3>";
				}					
				
				// marcamos o bloco clicado com 'x' se ação estiver setada e o bloco for null
				if (isset($acao) && $matrizComBombas[$clickLinha][$clickColuna] != $bomba) {
					$matrizMarcada[$clickLinha][$clickColuna] = 'x';	
					// $matrizComBombas[$clickLinha][$clickColuna] = 'x';					
				}

				$contadorDaVitoria = 0;

				// matriz apresentada no front
				foreach ($matrizComBombas as $l => $linha) {

					echo "<tr>";

						 foreach ($linha as $c => $coluna) {

						 	$tdColor = 'grey';
						 	$text = 0;

						 	// contamos quantos campos null existem na matriz
						 	if ($coluna == null) {
						 		$contadorDaVitoria++;
						 	}					 						 	

						 	if ($matrizMarcada[$l][$c] == 'x') {
						 		$tdColor = 'transparent';						 		
						 	}						 	

						 	if ($fim == true || $clickBomba == true) {
						 		$tdColor = 'transparent';
						 		$text = '10px';
						 		if ($coluna == $bomba) {
						 			$tdColor = 'crimson';
						 		}
						 	}

						 	if ($coluna != $bomba && $acao) {
						 		echo "<td style='background-color: {$tdColor};font-size: {$text};' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$l}&coluna={$c}&marked=x\"';'>{$coluna}</td>";
						 	} else {
						 		echo "<td style='background-color: {$tdColor};font-size: {$text};' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$l}&coluna={$c}\"';'>{$coluna}</td>";
						 	}
			 	
						 }

					echo "</tr>";
				
				}			

				// DEBUG
				if ($acao) {
					echo "<script>console.log('Você clicou na linha {$clickLinha}, coluna {$clickColuna}');</script>";
				}

				// gravamos as alterações na matriz da sessão para não perder após recarregar a página
				$_SESSION['matrizComBombas'] = $matrizComBombas;
				
			?>

		</table>

		<?php
			// if ($clickBomba == true) {
			// 	echo '<iframe src="https://giphy.com/embed/GW10shdM3oXok" width="480" height="377" align="center" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/ace-ventura-loser-GW10shdM3oXok">via GIPHY</a></p>';
			// }
		?>

	</div>
	
</body>
</html>

<?php

r($matrizComBombas, $matrizMarcada, $_SESSION, $contadorDaVitoria);

// if ($coluna == $bomba) {
// 	$tdColor = 'crimson';
// } elseif ($coluna != null && $coluna != 'x') {
// 	$tdColor = 'gold';
// }

// // l - 1
// if (isset($matrizComBombas[$clickLinha - 1][$clickColuna])) {
// 	if ($matrizComBombas[$clickLinha - 1][$clickColuna] == null) {
// 		$matrizComBombas[$clickLinha - 1][$clickColuna] = 'x';
// 	}
// }

// // l - 1 | c + 1
// if (isset($matrizComBombas[$clickLinha - 1][$clickColuna + 1])) {
// 	if ($matrizComBombas[$clickLinha - 1][$clickColuna + 1] != $bomba) {
// 		$matrizComBombas[$clickLinha - 1][$clickColuna + 1] = 'x';
// 	}
// }

// // c + 1
// if (isset($matrizComBombas[$clickLinha][$clickColuna + 1])) {
// 	if ($matrizComBombas[$clickLinha][$clickColuna + 1] != $bomba) {
// 		$matrizComBombas[$clickLinha][$clickColuna + 1] = 'x';
// 	}
// }

// // l - 1 | c + 1
// if (isset($matrizComBombas[$clickLinha + 1][$clickColuna + 1])) {
// 	if ($matrizComBombas[$clickLinha + 1][$clickColuna + 1] != $bomba) {
// 		$matrizComBombas[$clickLinha + 1][$clickColuna + 1] = 'x';
// 	}
// }

// // l + 1
// if (isset($matrizComBombas[$clickLinha + 1][$clickColuna])) {
// 	if ($matrizComBombas[$clickLinha + 1][$clickColuna] != $bomba) {
// 		$matrizComBombas[$clickLinha + 1][$clickColuna] = 'x';
// 	}
// }

// // l + 1 | c - 1
// if (isset($matrizComBombas[$clickLinha + 1][$clickColuna - 1])) {
// 	if ($matrizComBombas[$clickLinha + 1][$clickColuna - 1] != $bomba) {
// 		$matrizComBombas[$clickLinha + 1][$clickColuna - 1] = 'x';
// 	}
// }

// // c - 1
// if (isset($matrizComBombas[$clickLinha][$clickColuna - 1])) {
// 	if ($matrizComBombas[$clickLinha][$clickColuna - 1] != $bomba) {
// 		$matrizComBombas[$clickLinha][$clickColuna - 1] = 'x';
// 	}
// }

// // c - 1
// if (isset($matrizComBombas[$clickLinha - 1][$clickColuna - 1])) {
// 	if ($matrizComBombas[$clickLinha - 1][$clickColuna - 1] != $bomba) {
// 		$matrizComBombas[$clickLinha - 1][$clickColuna - 1] = 'x';
// 	}
// }

?>


