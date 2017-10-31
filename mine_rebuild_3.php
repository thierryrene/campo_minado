<?php

if (!isset($_SESSION)) {
	session_start();
}

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	require_once '../composer/vendor/autoload.php';    
}

$linhas = 5;
$colunas = $linhas;
$bombas = 5;
$bomba = '@';

$totalCells = $linhas * $colunas;

if ( isset($_REQUEST['linha']  ))    $clickLinha   = $_REQUEST['linha'];
if ( isset($_REQUEST['coluna'] ))    $clickColuna  = $_REQUEST['coluna'];
if ( isset($_REQUEST['acao']   ))	 $acao	       = true;

$vetorComBombas = array();

$vetorComBombasContador = 1;

for ($a = 1; $a <= $totalCells; $a++) {
	if ($a <= $bombas) {
		$vetorComBombas[$a] = $bomba;
	} else {
		$vetorComBombas[$a] = null;
	}
}

shuffle($vetorComBombas);

$matrizComBombas = array();

$count = 0;

for ($a = 1; $a <= $linhas; $a++) {
	for($b = 1; $b <= $colunas; $b++) {
		$matrizComBombas[$a][$b] = $vetorComBombas[$count];
		$count++;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	
	<div class="container" style="margin-top: 100px;">
		
		<div class="row">

			<div class="col-md-6">

				<table border="1" class="table table-responsive table-bordered text-center">
		
					<?php

						foreach ($matrizComBombas as $l => $linha) {
							echo "<tr>";
								foreach($linha as $c => $coluna) {
									echo "<td onclick='javascript: window.location=\"mine_rebuild_3.php?acao=true?linha={$l}&coluna={$c}\"';'></td>";
								}
							echo "</tr>";
						}

					?>

				</table>
							
			</div>

		</div>

	</div>



<?php

r($matrizComBombas);

?>	
	
</body>
</html>

