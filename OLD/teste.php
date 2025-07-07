<head>

<style type="text/css">

        tr:nth-child(even) td {
        background: #ffc;
        }
        tr:nth-child(odd) td {
        background: #eee; /* Linhas com fundo cinza */
        }
        BODY{
        font-family: Calibri;
        } 
</style>
</head>
<body TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0>

<table border="1px" cellpadding="5px" cellspacing="0"><TR>
<td><center><b>ID</b></center></td>
<td><center><b>Nome</b></center></td>
<td><center><b>Telefone</b></center></td>
<td><center><b>Cargo</b></center></td>
<td><center><b>Departamento</b></center></td>
<td><center><b>Local</b></center></td>
<td><center><b>E-mail</b></center></td>
</tr>


<?php
$i;
$pessoa = array();

			for ($i=0; $i < 900; $i++){

				$pessoa += [$i => array(
					'nome' => 'zé',
					'telefone' => '00-0000-0000',
					'cargo' => 'pião',
					'departamento' => 'fazenda',
					'andar' => 'terreo',
					'Email' => 'eu@eu.com')];


			}

		$result = count($pessoa);

		Echo "Foram encontrados " . $result . " pessoas nesta pesquisa.<br><br><br>";
		sort($pessoa);
			for ($i=0; $i < $result; $i++){
				echo "<tr><td><center>". ($i+1) ."</center></td>";
				echo "<td>".$pessoa[$i][nome]."</td>";
				echo "<td>".$pessoa[$i][telefone]."</td>";
				echo "<td>".$pessoa[$i][cargo]."</td>";
				echo "<td>".$pessoa[$i][departamento]."</td>";
				echo "<td>".$pessoa[$i][andar]."</td>";
}

