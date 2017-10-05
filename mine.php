<?php

require 'composer/vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style type="text/css">
		td {
			padding: 15px;
			background-color: #ccc;
		}
		table td {
			border: solid 5px #eee;
		}
	</style>
</head>
<body>
	

	<div align="center" style="margin-top: 100px;">


		<table border='0'>

			<tr>
		
				<?php				

					// valores iniciais
					$linhas 		= 5;
					$colunas 		= 5;
					$bombas 		= 5;
					$firstMcount 	= 0;

					// valores url
					$acao 			= !empty($_REQUEST['acao']) ? $_REQUEST['acao'] : '';
					$clickLinha 	= !empty($_REQUEST['linha']) ? $_REQUEST['linha'] : 0;
					$clickColuna 	= !empty($_REQUEST['coluna']) ? $_REQUEST['coluna'] : 0;

					// contadores
					$cellCount = 1;

					// array que vai abrir a máscara da matriz que vamos utilizar
					$firstM = array();				

					// criamos a matriz com base nas variáveis linhas e colunas
					for ($a = 1; $a <= $linhas; $a++) {						
						echo "<tr>";
							for($b = 1; $b <= $colunas; $b++) {
								echo "<td><a href='?acao=true&linha={$a}&coluna={$b}&celula={$cellCount}'>{$cellCount}</a></td>";
								$firstM[$a][$b] =  $cellCount;
								$cellCount++;
							}
						echo "</tr>";
					}

					// se houver ação de click, apresentar mensagem de qual célula foi clicada
					if ($_GET['acao']) {
						session_start();
						$linha 	= $_GET['linha'];
						$coluna = $_GET['coluna'];
						echo "você clicou na linha {$linha}, célula {$coluna}.";
					}

					// matriz mask
					for ($l = 1; $l <= $linhas; $l++) {
						for($c = 1; $c <= $colunas; $c++) {
							$firstM[$l][$c] = null;
							$firstMcount++;
						}
					}					

				?>

			</tr>

		</table>

	</div>


	<?php

		echo "<pre>";
		r($GLOBALS);

	?>
	
</body>
</html>