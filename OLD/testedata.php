131385547879192683

<?php



date_default_timezone_set('America/Sao_Paulo');
$data = date('d-m-Y');

$logon = 131385547879192683;
		$winInterval = round($logon / 10000000);
		$unixTimestamp = ($winInterval - 11644473600);

		$ultimadata = date("d-m-Y", $unixTimestamp);


		$data_inicial = $ultimadata;
		$data_final = $data;

		// Calcula a diferença em segundos entre as datas
		$diferenca = strtotime($data_final) - strtotime($data_inicial);

		//Calcula a diferença em dias
		$dias = floor($diferenca / (60 * 60 * 24));

echo $ultimadata." - ".$dias;
