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
	

	<div align="center" style="margin-top: 100px;">

		<h1>Mine</h1>

		<br>

		<p><a href="mine.php" class="button">New</a></p>

		<br>

		<table border='0'>

			<tr>
		
				<?php				

					session_start();

					// valores iniciais
					$linhas 		= 5;
					$colunas 		= 5;
					$bombas 		= 4;
					$bomba 			= "@";
					$bombasMedia 	= ceil(($linhas * $colunas) / $bombas);

					// valores url
					$acao 			= !empty($_REQUEST['acao']) ? true : false;
					$clickLinha 	= !empty($_REQUEST['linha']) ? $_REQUEST['linha'] : 0;
					$clickColuna 	= !empty($_REQUEST['coluna']) ? $_REQUEST['coluna'] : 0;

					// contadores
					$cellCount 				= 0;				

					// array que vai abrir a máscara da matriz que vamos utilizar
					$firstMaskArray = array();

					// criamos a matriz com base nas variáveis linhas e colunas
					for ($a = 1; $a <= $linhas; $a++) {						
						echo "<tr>";
							for($b = 1; $b <= $colunas; $b++) {
								echo "<td><a href='?acao=true&linha={$a}&coluna={$b}&celula={$cellCount}'>{$cellCount}</a></td>";
								$firstMaskArray[$a][$b] = $cellCount;
								$cellCount++;
							}
						echo "</tr>";
					}

					// salvamos o jogo na sessão
					// $_SESSION['firstM'] = $firstMaskArray;
					// session_destroy($_SESSION);
					
				?>

			</tr>

		</table>

		<br>
		<br>

		<?php
			// se houver ação de click, apresentar mensagem de qual célula foi clicada
			if ($_GET['acao']) {
				$linha 	= $_GET['linha'];
				$coluna = $_GET['coluna'];
				$celula = $_GET['celula'];
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