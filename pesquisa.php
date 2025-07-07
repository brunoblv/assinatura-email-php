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
<center>
<table border="1px" cellpadding="5px" cellspacing="0"><TR>
<td><center><b>ID</b></center></td>
<td width=900px><center><b>Colaborador</b></center></td>

</tr>


<?php

include "config.php";

$ldap_server = "ldap://10.10.65.242"; 
$dominio = "rede";

$auth_user = "rede\usr_smdu_Freenas"; 
$auth_pass = "Prodam01"; 
$pessoa = array();
$SMDU = array();
$SEL = array();
$SPURBANISMO = array();


$base_dn = "OU=Users,OU=SMUL,DC=rede,DC=sp"; 

$pesquisa = $_GET['contato'];

if ($pesquisa == "") { $pesquisa = "*"; }else{ $pesquisa = "*".$_GET['contato']."*";}

$count;


$filter = "(&(objectClass=user)(objectCategory=person)(|(cn=$pesquisa)(samaccountname=$pesquisa))(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";



if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);

$count = $info["count"];


		for ($i=0; $i < $count; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = mb_convert_encoding($info[$i]["displayname"][0], 'UTF-8','ISO-8859-1');
		$busca = mysqli_query($mysqli, "select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysqli_num_rows($busca)>0) {
				while ($dados = mysqli_fetch_array($busca)) {

				$SMDU += [$ID_Rede => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'secretaria' => $dados['cp_secretaria'],
					'andar' => $dados['cp_andar'],
					'cep' => $dados['cp_cep'],
					'Email' => $dados['cp_email'],
					'Dia' => $dados['cp_nasc_dia'],
					'Mes' => $dados['cp_nasc_mes'])];
	
				}
			}else if ($Nome != "" && $Email != ""){

				$SMDU += [$ID_Rede => array(
				    'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'departamento' => '',
					'secretaria' => '',
					'andar' => '',
					'cep' => '',
					'Email' => mb_strtolower($Email),
					'Dia' => '',
					'Mes' => '')];


			}

 		}
 		

 		}


	}


 }



// Fecha a conexao LDAP.
ldap_close($connect);


$base_dn = "OU=Users,OU=SMUL,DC=rede,DC=sp"; 


if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);



$count = $info["count"];



		for ($i=0; $i < $count; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = mb_convert_encoding($info[$i]["displayname"][0], 'UTF-8','ISO-8859-1');
		$busca = mysqli_query($mysqli, "select * from tbl_telefones WHERE cp_usuario_rede LIKE '%$ID_Rede%' ORDER BY cp_nome ASC"); 

			if (mysqli_num_rows($busca)>0) {
				while ($dados = mysqli_fetch_array($busca)) {

				$SEL += [$ID_Rede => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' =>$dados['cp_cargo'],
					'secretaria' => $dados['cp_secretaria'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'cep' => $dados['cp_cep'],
					'Email' => $dados['cp_email'],
					'Dia' => $dados['cp_nasc_dia'],
					'Mes' => $dados['cp_nasc_mes'])];
	
				}
			}else if ($Nome != "" && $Email != ""){

				$SEL += [$ID_Rede => array(
				    'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'secretaria' => '',
					'departamento' => '',
					'andar' => '',
					'cep' => '',
					'Email' => mb_strtolower($Email),
					'Dia' => '',
					'Mes' => '')];

			}
		


 		}  

/*
$base_dn = "OU=Users,OU=ILUME,DC=rede,DC=sp"; 


if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);



$count = $info["count"];



		for ($i=0; $i < $count; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);
		$busca = mysqli_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '%$ID_Rede%' ORDER BY cp_nome ASC"); 

			if (mysqli_num_rows($busca)>0) {
				while ($dados = mysqli_fetch_array($busca)) {

				$ILUME += [$ID_Rede => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'secretaria' => $dados['cp_secretaria'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'cep' => $cep['cp_cep'],
					'Email' => $dados['cp_email'],
					'Dia' => $dados['cp_nasc_dia'],
					'Mes' => $dados['cp_nasc_mes'])];
	
				}
			}else if ($Nome != "" && $Email != ""){

				$ILUME += [$ID_Rede => array(
				    'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'secretaria' => '',
					'departamento' => '',
					'andar' => '',
					'cep' => '',
					'Email' => mb_strtolower($Email),
					'Dia' => '',
					'Mes' => '')];

			}
		


 		}  
}
}

		
*/		
		
$base_dn = "OU=Users,OU=SPURBANISMO,DC=rede,DC=sp"; 

$pesquisa = $_GET['contato'];

if ($pesquisa == "") { $pesquisa = "*"; }else{ $pesquisa = "*".$_GET['contato']."*";}

$count;


$filter = "(&(objectClass=user)(objectCategory=person)(|(cn=$pesquisa)(samaccountname=$pesquisa))(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";



if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);

$count = $info["count"];


		for ($i=0; $i < $count; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = mb_convert_encoding($info[$i]["displayname"][0], 'UTF-8','ISO-8859-1');
		$busca = mysqli_query($mysqli, "select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysqli_num_rows($busca)>0) {
				while ($dados = mysqli_fetch_array($busca)) {

				$SPURBANISMO += [$ID_Rede => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'secretaria' => $dados['cp_secretaria'],
					'andar' => $dados['cp_andar'],
					'cep' => $dados['cp_cep'],
					'Email' => $dados['cp_email'],
					'Dia' => $dados['cp_nasc_dia'],
					'Mes' => $dados['cp_nasc_mes'])];
	
				}
			}else if ($Nome != "" && $Email != ""){

				//$SPURBANISMO += [$ID_Rede => array(
				//    'nome' => $Nome,
				//	'telefone' => '',
				//	'cargo' => '',
				//	'departamento' => '',
				//	'secretaria' => '',
				//	'andar' => '',
				//	'cep' => '',
				//	'Email' => mb_strtolower($Email))];

			}

 		}
 		

 		}


	}


 }



// Fecha a conexao LDAP.
ldap_close($connect);



		$pessoa = array_merge($SMDU, $SEL, $SPURBANISMO);


		$result = count($pessoa);

		Echo "<br>Foram encontrados " . $result . " pessoas pesquisa.<br><br>";
		sort($pessoa);
			for ($i=0; $i < $result; $i++){
				$cep = "";
				if ($pessoa[$i][cep]) {
					$cep = " | CEP: ".$pessoa[$i][cep];
				}

				echo "<tr><td ><center>". ($i+1) ."</center></td>";
				echo "<td><b>Nome:</b> ".$pessoa[$i][nome].
				"<br><b>Cargo: </b>".$pessoa[$i][cargo].
				"<br><b>Tel.: </b>".$pessoa[$i][telefone].

				"<br><b>Unidade: </b> ".$pessoa[$i][secretaria]." - ".$pessoa[$i][departamento].
				"<br><b>Local: </b> ".$pessoa[$i][andar]. $cep .
				"<br><b>Aniversário: </b>".$pessoa[$i][Dia]." / ".$pessoa[$i][Mes].
				"<br><b>E-mail: </b>"."<a href=mailto:".$pessoa[$i][Email].">".$pessoa[$i][Email]."</a></td>";
			}


 		}



	}



mysqli_close($mysqli);

 }



// Fecha a conexao LDAP.
ldap_close($connect);


?>