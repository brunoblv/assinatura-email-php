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
$auth_pass = "Hta123P@"; 
$pessoa = array();
$SMDU = array();
$SEL = array();
$SPURBANISMO = array();


$base_dn = "OU=Users,OU=SMDU,DC=rede,DC=sp"; 

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
		$Nome = utf8_encode($info[$i]["displayname"][0]);
		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {

				$SMDU += [$ID_Rede => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'secretaria' => $dados['cp_secretaria'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'])];
	
				}
			}else if ($Nome != "" && $Email != ""){

				$SMDU += [$ID_Rede => array(
				    'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'departamento' => '',
					'secretaria' => '',
					'andar' => '',
					'Email' => mb_strtolower($Email))];

			}

 		}
 		

 		}


	}


 }



// Fecha a conexao LDAP.
ldap_close($connect);





$base_dn = "OU=Users,OU=SEL,DC=rede,DC=sp"; 


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
		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '%$ID_Rede%' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {

				$SEL += [$ID_Rede => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'secretaria' => $dados['cp_secretaria'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'])];
	
				}
			}else if ($Nome != "" && $Email != ""){

				$SEL += [$ID_Rede => array(
				    'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'secretaria' => '',
					'departamento' => '',
					'andar' => '',
					'Email' => mb_strtolower($Email))];

			}
		


 		}  

		
		
		
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
		$Nome = utf8_encode($info[$i]["displayname"][0]);
		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {

				$SPURBANISMO += [$ID_Rede => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'secretaria' => $dados['cp_secretaria'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'])];
	
				}
			}else if ($Nome != "" && $Email != ""){

				//$SPURBANISMO += [$ID_Rede => array(
				//    'nome' => $Nome,
				//	'telefone' => '',
				//	'cargo' => '',
				//	'departamento' => '',
				//	'secretaria' => '',
				//	'andar' => '',
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
				echo "<tr><td ><center>". ($i+1) ."</center></td>";
				echo "<td><b>Nome:</b> ".$pessoa[$i][nome].
				"<br><b>Cargo: </b>".$pessoa[$i][cargo].
				"<br><b>Tel.: </b>".$pessoa[$i][telefone].

				"<br><b>Unidade: </b> ".$pessoa[$i][secretaria]." - ".$pessoa[$i][departamento].
				"<br><b>Local: </b> ".$pessoa[$i][andar].
				"<br><b>E-mail: </b>"."<a href=mailto:".$pessoa[$i][Email].">".$pessoa[$i][Email]."</a></td>";
			}


 		}



	}



mysql_close($db);

 }



// Fecha a conexao LDAP.
ldap_close($connect);


?>