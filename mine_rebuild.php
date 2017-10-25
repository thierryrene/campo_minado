<?php

session_start();

require_once '../composer/vendor/autoload.php';    

$linhas  = 10;
// colunas com o mesmo valor das linhas
$colunas = $linhas;
$bombas = 2;
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
	if (isset($acao) && $clickMouse == null) {
	
		foreach ($matrizComBombas as $l => $linha) {

			foreach ($linha as $c => $coluna) {
			
				// bloco de cima
				if (isset($matrizComBombas[$l + 1][$c])) {
					if ($matrizComBombas[$l + 1][$c] == null) {
						$matrizComBombas[$l + 1][$c] = 'transparent';							
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


			}

		}
	
	}

	if ($clickMouse == $bomba) {
		?>
		<script>

			var bomba = confirm('Você clicou em uma bomba. Jogo encerrado. :(');

			if (bomba == true) {
				window.location = "mine_rebuild.php";
			}

		</script>

		<?php
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
		<br>
		<h1>Mines!</h1>		
		<a href="mine_rebuild.php" style="padding: 8px 12px; background-color: green; color: snow; border: #424242 solid 1px; text-decoration: none;">NEW</a>
		<br>
		<br>
		<br>
	</div>

	<div style="margin:auto;">
		<table style="margin: auto;" border="1">
			
			<?php

				// r($matrizComBombas);		

				// matriz apresentada no front
				foreach ($matrizComBombas as $l => $linha) {

					echo "<tr>";

						foreach($linha as $c => $coluna) {

							if ($coluna == $bomba) {
								$coluna = '';
								$tdColor = 'grey';
							}

							if (isset($emptyBlock) && $coluna != null) {
								$tdColor = 'gold';
								echo "<td style='background-color: {$tdColor};' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$l}&coluna={$c}&empty=true\"';'>{$coluna}</td>";	
							} else {						
								$tdColor = ( isset($emptyBlock) && $coluna == null ) ? 'transparent' : 'grey';
								echo "<td style='background-color: {$tdColor};' onclick='javascript: window.location=\"mine_rebuild.php?acao=click&linha={$l}&coluna={$c}&empty=true\"';'></td>";
							}

						}

					echo "</tr>";

				}

				// apresentamos a linha e coluna que foram clicadas
				if (!empty($matrizComBombas) && $acao == 'click') {
					echo "<script>console.log('Você clicou na linha {$clickLinha}, coluna {$clickColuna}');</script>";
					echo "<script>console.log('Mouse click value: {$clickMouse}');</script>";
				}			

			?>

		</table>

	</div>

	
</body>
</html>

<?php

r($matrizComBombas);

?>