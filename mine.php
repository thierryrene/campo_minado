
<?php 
/**
 * ações do campo minado
 */
require 'vendor/autoload.php'; 

use CampoMinado\Matrix;

if (empty($_SESSION)) session_start();
$clear = new CampoMinado\FieldSelect();

if (empty($_SESSION['matrix'])) {

	$matrix = new Matrix();
	$_SESSION['matrix'] = $matrix->generate(10, 13);
	
}

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
		
		<?php				


			// valores url que vamos utilizar para manipular o programa através da URL
			$acao 	= !empty($_REQUEST['acao']) ? $_REQUEST['acao'] : null;
			$linha 	= isset($_REQUEST['linha']) && is_numeric($_REQUEST['linha']) ? $_REQUEST['linha'] : null;
			$column = isset($_REQUEST['coluna']) && is_numeric($_REQUEST['coluna']) ? $_REQUEST['coluna'] : null;					


			if ($acao == 'click' ) {				
				echo '<pre>';
				$success = $clear->try($_SESSION['matrix'], $linha, $column);
				
				if (!$success['success']) {
					die('acertou uma bomba');
				}

				$_SESSION['matrix'] = $success['matrix'];

			} else {
				$matrix = new Matrix();
				$_SESSION['matrix'] = $matrix->generate(10, 13);

			}

			// unset($vetorBombas, $a, $b, $onPageMask);				
			
		?>


		<table>	

			<?php
								
				foreach ($_SESSION['matrix'] as $r => $row) {

					echo "<tr>";

						foreach ($row as $c => $column) {	
							
							$item = 'x';
							if (Matrix::CLEAR == $column) {
								$item = 'c';
							}

							echo "<td onclick='javascript: window.location=\"mine.php?acao=click&linha={$r}&coluna={$c}\";' style='padding: 15px;'>".$item."</td>";
							
							
						}
				
					echo "</tr>";
				}								
			
			?>

		</table>

	</div>

</body>
</html>