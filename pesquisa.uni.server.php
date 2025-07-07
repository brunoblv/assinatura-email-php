<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lista de todos usu√°rios da rede.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">


        BODY{
        font-family: Calibri;
        } 
</style>

</head>
<body TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0>


<?php

set_time_limit(0);

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




//$usuario = $_GET['usuario'];
//$Rede = $_GET['rede'];

$filter = "(&(objectClass=user)(objectCategory=person)(|(cn=$pesquisa)(samaccountname=$pesquisa))(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";


if (!($connect=@ldap_connect($ldap_server))) die("Erro 1: Conex„o LDAP.");

    ldap_set_option($connect, ldap_opt_protocol_version, 3);
    //ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
    ldap_set_option($connect, LDAP_OPT_TIMELIMIT, 120);
    ldap_set_option($connect, LDAP_OPT_NETWORK_TIMEOUT, 120);

	if (!($bind=@ldap_bind($connect, $auth_user, $auth_pass)))    die("Erro 2: Erro no BIND.");

		if (!($search=@ldap_search($connect, $base_dn, $filter)))   die("Erro 3: Erro no search.");

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);

		$logon = $info[$i]["lastlogon"][0];

		if (!($logon == "" || $logon == "0" || $logon == NULL)) {

			$ultimadata = date("d-m-Y", $logon/10000000-11644473600);

		
			$data_inicial = new DateTime($ultimadata);
			$data_final = new DateTime($data);


    			$dateInterval = $data_inicial->diff($data_final);
   			$dias = $dateInterval->days;



			}else{ 

			$ultimadata = "Nunca";
		
		}


		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				if ($dias<730) { $ultimologon =  $ultimadata.' - '.$dias.' dias'; }else{$ultimologon = ''; }
				$diasalto = $dias;
				$smdu += [$i => array(
					'ultimologon' => $ultimadata,
					'diasalto' => $dias)];
	
				}
			}else{
				$smdu += [$i => array(
					'ultimologon' => $ultimadata,
					'diasalto' => $dias )];
			}
 		}
 




// Fecha a conexao LDAP.
ldap_close($connect);


$base_dn = "OU=Users,OU=SEL,DC=rede,DC=sp"; 


if (!($connect=@ldap_connect($ldap_server)))  die("Erro 4: Conex„o LDAP.");

    ldap_set_option($connect, ldap_opt_protocol_version, 3);
    //ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
    ldap_set_option($connect, LDAP_OPT_TIMELIMIT, 120);
    ldap_set_option($connect, LDAP_OPT_NETWORK_TIMEOUT, 120);

	if (!($bind=@ldap_bind($connect, $auth_user, $auth_pass))) die("Erro 5: Erro no BIND.");

		if (!($search=@ldap_search($connect, $base_dn, $filter))) die("Erro 6: Erro no search.");

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);

		$logon = $info[$i]["lastlogon"][0];

		if (!($logon == "" || $logon == "0" || $logon == NULL)) {

			$ultimadata = date("d-m-Y", $logon/10000000-11644473600);
		
			$data_inicial = new DateTime($ultimadata);
			$data_final = new DateTime($data);


    			$dateInterval = $data_inicial->diff($data_final);
   			$dias = $dateInterval->days;

		}else{ 

			$ultimadata = "Nunca";
		
		}



		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				//if ($dias<730) { $ultimologon =  $ultimadata.' - '.$dias.' dias'; }else{$ultimologon = ''; }
				$diasalto = $dias;
				$sel += [$i => array(
					'ultimologon' => $ultimadata,
					'diasalto' => $dias)];
	
				}
			}else{
				$sel += [$i => array(
					'ultimologon' => $ultimadata,
					'diasalto' => $dias)];
			}


 		}
 		

		$pessoa = array_merge($smdu, $sel);

		$result = count($pessoa);

			for ($i=0; $i < $result; $i++){

			echo "<center><table><tr>";

		if (!($pessoa[$i][ultimologon] == "Nunca")) {
				if ($pessoa[$i][diasalto] >= "60") { 
					echo "<td><center><font color=red><b>". $pessoa[$i][ultimologon]." - ". $pessoa[$i][diasalto]." dias</b></font></td></tr>";
				}else{ 	
					echo "<td><center>". $pessoa[$i][ultimologon]." - ". $pessoa[$i][diasalto]." dias</td></tr>";
				}
		}else{ 
			echo "<td><font color=red><b>". $pessoa[$i][ultimologon]."</b></font></td></tr>";
				
		}

  

 ////echo "<td>".$entries[$i]["operatingsystem"][0]."</td>";
			}





mysql_close($db);




// Fecha a conexao LDAP.
ldap_close($connect);



?>