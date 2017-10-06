<?php

require '../composer/vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style type="text/css">
		* {
			font-family: arial;
		}
		td {
			background-color: #ccc;
			padding: 20px;
			text-align: center;
		}
		table td {
			/*border: solid 5px #eee;*/
		}
		.button {
			padding: 10px 15px;
			background-color: #89ba16;
			border: 1px solid gray;
			color: snow;
			text-decoration: none;
			font-weight: bold;
			text-transform: uppercase;
		}

		.alert {
			padding: 10px 15px;
			margin-top: 10px;
			background-color: gold;
			text-transform: uppercase;
			font-weight: bold;
		}
		a {
			text-decoration: none;
		}
	</style>
</head>
<body>
	

	<div align="center" style="margin-top: 60px;">

		<h1>Mine</h1>

		<br>

		<p><a href="mine.php" class="button">New</a></p>

		<br>

		<table border='0'>

			<tr>
		
				<?php				

					session_start();

					// valores iniciais
					$linhas 		= 10;
					$colunas 		= 10;
					$bombas 		= 10;
					$bomba 			= "@";

					// valores url
					$acao 			= !empty($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
					$clickLinha 	= !empty($_REQUEST['linha']) ? $_REQUEST['linha'] : null;
					$clickColuna 	= !empty($_REQUEST['coluna']) ? $_REQUEST['coluna'] : null;
					$cell 			= !empty($_REQUEST['celula']) ? $_REQUEST['celula'] : null;

					// contador para total de células na matriz
					$cellCount = 0;		

					// array que vai abrir a máscara da matriz que vamos utilizar
					$onPageMask = array();

					// criamos a matriz com base nas variáveis linhas e colunas
					for ($a = 1; $a <= $linhas; $a++) {
						for($b = 1; $b <= $colunas; $b++) {
							// criamos a matriz na variável $onPageMask
							$onPageMask[$a][$b] = $cellCount;
							$cellCount++;
						}
					}			

					// cópia da primeira matriz criada
					$finalArray = $onPageMask;						

					// criar o array que vai armezenar as bombas
					$vetorBombas = array();

					if ($acao != 'click' || $acao == '') {				

						// criamos um vetor com a média de bombas
						for ($a = 1; $a <= $cellCount; $a++) {
							if ($a <= $bombas) {
								$vetorBombas[$a] = $bomba;							
							} else {
								$vetorBombas[$a] = null;
							}						
						}

						// randomizamos os valores do vetor
						shuffle($vetorBombas);

						// iniciado o contador para o for abaixo
						$tot = 1;

						// for para recriar matriz com as bombas
						for($l = 1; $l <= $linhas; $l++) {
							for($c = 1; $c <= $colunas; $c++) {

								// definimos os valores de cada célula do array com base no vetor de bombas randomizado
								$finalArray[$l][$c] = $vetorBombas[$tot];							
								
								// utilizamos um contador para incluir os valores de mesmo indíce na matriz
								$tot++;

							}
						}				

						$count = 1;

						for ($l = 1; $l <= $linhas; $l++) {
							echo "<tr>";
								foreach ($finalArray[$l] as $item) {
									if ($item != '@') $item = 'x';
									echo "<td>
											<a href='?acao=click&linha={$l}&coluna={$c}&celula={$count}'>{$item}</a>
										  </td>";
									$onPageMask[$a][$b] = $cellCount;
									$count++;
								}
							echo "</tr>";
						}

						$_SESSION['finalArray'] = $finalArray;

					} else {

						$finalArray = $_SESSION['finalArray'];

						$linha 	= $_REQUEST['linha'];
						$coluna = $_REQUEST['coluna'];
						$celula = $_REQUEST['celula'];

						echo "<span class='alert'>linha {$linha}, coluna {$coluna}, célula {$celula}</span>";

						// unset($linha, $coluna, $celula);

					}

					// unset($vetorBombas, $a, $b, $onPageMask);				
					
				?>

			</tr>

		</table>

		<br>
		<br>

		<table>	

			<?php
								
				// for ($l = 1; $l <= $linhas; $l++) {
				// 	echo "<tr>";
				// 		foreach ($finalArray[$l] as $item) {
				// 			if ($item != '@') $item = 'x';
				// 			echo "<td>
				// 					<a href='?acao=click&linha={$l}&coluna={$c}&celula={$count}'>{$item}</a>
				// 				  </td>";
				// 			$onPageMask[$a][$b] = $cellCount;
				// 			$count++;
				// 		}
				// 	echo "</tr>";
				// }
				
				// unset($linha, $coluna, $celula);
			
			?>

		</table>

	</div>


	<?php	

		echo "<pre>";
		r($GLOBALS);

	?>
	
</body>
</html>