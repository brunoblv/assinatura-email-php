<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lista de todos usuários da rede.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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


<?php

include "config.php";

$ldap_server = $_GET['servidor'];


$auth_user = "rede\usr_smdu_Freenas"; 
$auth_pass = "Hta123P@"; 
$pessoa = array();
$smdu = array();
$sel = array();


$base_dn = "OU=Users,OU=SMDU,DC=rede,DC=sp"; 

$pesquisa = $_GET['contato'];

if ($pesquisa == "") { $pesquisa = "*"; }else{ $pesquisa = "*".$_GET['contato']."*";}


date_default_timezone_set('America/Sao_Paulo');
$data = date('d-m-Y');


function calculaDiferenca($DataEvento){
    $hoje = new DateTime();
    $diferenca = $hoje->diff(new DateTime($DataEvento));
    return $diferenca->days;
}




$usuario = $_GET['usuario'];
$Rede = $_GET['rede'];

$filter = "(&(objectClass=user)(objectCategory=person)(|(cn=$pesquisa)(samaccountname=$pesquisa))(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";


if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);

		$logon = $info[$i]["lastlogon"][0];
		$winInterval = round($logon / 10000000);
		$unixTimestamp = ($winInterval - 11644473600);

		$ultimadata = date("d-m-Y", $unixTimestamp);


		$data_inicial = $ultimadata;
		$data_final = $data;

		// Calcula a diferença em segundos entre as datas
		$diferenca = strtotime($data_final) - strtotime($data_inicial);

		//Calcula a diferença em dias
		$dias = floor($diferenca / (60 * 60 * 24));



		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				if ($dias<730) { $ultimologon =  $ultimadata.' - '.$dias.' dias'; }else{$ultimologon = ''; }
				$diasalto = $dias;
				$smdu += [$i => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'],
					'usuario' => $ID_Rede,
					'ultimologon' => $ultimologon,
					'diasalto' => $diasalto )];
	
				}
			}else if ($Nome != "" && $Email != ""){
				$smdu += [$i => array(
				    	'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'departamento' => '',
					'andar' => '',
					'Email' => mb_strtolower($Email),
					'usuario' => $ID_Rede,
					'ultimologon' => $ultimologon,
					'diasalto' => $diasalto )];
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


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);

		$logon = $info[$i]["lastlogon"][0];
		$winInterval = round($logon / 10000000);
		$unixTimestamp = ($winInterval - 11644473600);

		$ultimadata = date("d-m-Y", $unixTimestamp);


		$data_inicial = $ultimadata;
		$data_final = $data;

		// Calcula a diferença em segundos entre as datas
		$diferenca = strtotime($data_final) - strtotime($data_inicial);

		//Calcula a diferença em dias
		$dias = floor($diferenca / (60 * 60 * 24));


		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				if ($dias<730) { $ultimologon =  $ultimadata.' - '.$dias.' dias'; }else{$ultimologon = ''; }
				$diasalto = $dias;
				$sel += [$i => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'],
					'usuario' => $ID_Rede,
					'ultimologon' => $ultimologon,
					'diasalto' => $diasalto)];
	
				}
			}else if ($Nome != "" && $Email != ""){
				$sel += [$i => array(
				    	'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'departamento' => '',
					'andar' => '',
					'Email' => mb_strtolower($Email),
					'usuario' => $ID_Rede,
					'ultimologon' => $ultimologon,
					'diasalto' => $diasalto)];
			}


 		}
 		

		$pessoa = array_merge($smdu, $sel);

		$result = count($pessoa);

			for ($i=0; $i < $result; $i++){

			echo "<table><tr>";
				if ($pessoa[$i][diasalto] >= "60") { 
					echo "<td><center><font color=red><b>". $pessoa[$i][ultimologon]."</b></font></td></tr>";
				}else{ 	
					echo "<td><center>". $pessoa[$i][ultimologon]."</td></tr>";
				}

  

 ////echo "<td>".$entries[$i]["operatingsystem"][0]."</td>";
			}


 		}
	}

mysql_close($db);

 }



// Fecha a conexao LDAP.
ldap_close($connect);



?>