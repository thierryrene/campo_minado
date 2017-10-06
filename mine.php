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
					$linhas 		= 6;
					$colunas 		= 6;
					$bombas 		= 8;
					$bomba 			= "@";
					$bombasMedia 	= ceil(($linhas * $colunas) / $bombas);

					// valores url
					$acao 			= !empty($_REQUEST['acao']) ? $_REQUEST['acao'] : '';
					$clickLinha 	= !empty($_REQUEST['linha']) ? $_REQUEST['linha'] : 0;
					$clickColuna 	= !empty($_REQUEST['coluna']) ? $_REQUEST['coluna'] : 0;

					// contadores
					$cellCount = 0;				

					// array que vai abrir a máscara da matriz que vamos utilizar
					$onPageMask = array();

					if ($acao == 'click') {

						// criamos a matriz com base nas variáveis linhas e colunas
						for ($a = 1; $a <= $linhas; $a++) {						
							echo "<tr>";
								for($b = 1; $b <= $colunas; $b++) {
									echo "<td><a href='?acao=click&linha={$a}&coluna={$b}&celula={$cellCount}'>{$cellCount}</a></td>";
									$onPageMask[$a][$b] = $cellCount;
									$cellCount++;
								}
							echo "</tr>";
						}
					}					

					$secondMask = array();

					for ($a = 1; $a <= $colunas; $a++) {
						$secondMask[$a] = $bomba;
					}

					$sortArray = array();

					for($a = 1; $a <= $linhas; $a++) {
						for($b = 1; $b <= $colunas; $b++) {
							$sortArray[$a][$b] = '';
						}
					}

					// shuffle($secondMask);
					
				?>

			</tr>

		</table>

		<br>
		<br>

		<?php

			// se houver ação de click, apresentar mensagem de qual célula foi clicada
			if ($_REQUEST['acao']) {

				$linha 	= $_REQUEST['linha'];
				$coluna = $_REQUEST['coluna'];
				$celula = $_REQUEST['celula'];

				echo "<span class='alert'>linha {$linha}, coluna {$coluna}, célula {$celula}</span>";

				unset($linha, $coluna, $celula);

			}
			
		?>

	</div>


	<?php	

		echo "<pre>";
		r($GLOBALS);

	?>
	
</body>
</html>