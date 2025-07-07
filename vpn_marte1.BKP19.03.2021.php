<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lista de usuários com acesso VPN MARTE1.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<style type="text/css">

table {
    border-collapse: collapse;

}
        tr, td {
        background: #eee;
		    padding: 8px;
        }

        tr:nth-child(2n+3) td {
        background: #ffc;
		    padding: 8px;
        }
		
		
        tr:nth-child(even) td {
        background: #eee;
		    padding: 8px;
        }
        <-tr:nth-child(odd) td {
        background: #eee; /* Linhas com fundo cinza */
        }-->
        BODY{
        font-family: Calibri;
        } 

    #posiciona {
	display: none;
        position: fixed; /* posição absoluta ao elemento pai, neste caso o BODY */
        /* Posiciona no meio, tanto em relação a esquerda como ao topo */
        left: 50%; 
        top: 50%;
        width: 800px; /* Largura da DIV */
        height: 350px; /* Altura da DIV */
        /* A margem a esquerda deve ser menos a metade da largura */
        /* A margem ao topo deve ser menos a metade da altura */
        /* Fazendo isso, centralizará a DIV */
        margin-left: -400px;
        margin-top: -200px;
        background-color: #FFF;
        color: #FFF;
        background-color: #666;
        text-align: center; /* Centraliza o texto */
        z-index: 1000; /* Faz com que fique sobre todos os elementos da página */
    }
    #fechar { margin: 5px; font-size: 12px; }
  </style>

  <script>
    function fechar() { 
        document.getElementById("posiciona").style.display = 'none'; 
    }

    function abre() { 
        document.getElementById("posiciona").style.display = 'block'; 
    }

window.onresize = function(){
document.getElementById('verifica_IFRAME').style.bottom = "0";
}
 </script>
</head>



<body TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0>
<center><h1>Lista de usuários com acesso VPN MARTE1.</h1>

<form action="http://10.75.17.88/ass/vpn_marte1.php" autocomplete="ON" method="get" name="form">Pesquisar: <input maxlength="50" name="contato" size="50" type="text" value="<?php echo $_GET['contato']; ?>"><input type="submit" value="Pesquisar" />
<a href="http://10.75.17.88/ass/pesquisa.xls.php?contato=" target="_self"><img class="" src="http://10.75.17.88/wp-content/uploads/2017/06/excel-xls-icon.png" alt="" width="37" height="49" /></a></form>

<form action="mailto:dsmischiatti@prefeitura.sp.gov.br?bcc=smulsuporte@prefeitura.sp.gov.br&subject=Usuários com mais de 60 dias sem logar na rede.&body=Voc~e não escolheu nenhum usuário..." method="post" name="meu_formulario" enctype="text/plain">
<br>

<input type="hidden" name="Segue usuários para conferência para desativação por tempo sem logar na rede:" value=".">
<table border="1px" cellpadding="5px" cellspacing="0">

<TR>

<td colspan=7><center><b>Dados da assinatura de E-mail</b></center></td>
<td colspan=3><center><b>Acesso no AD</b></center></td>
<td colspan=2 ><center><b>FFI</b></center></td>
<TR>

<td><center><b>Usuário</b></center></td>
<td><center><b>Nome</b></center></td>
<td><center><b>Telefone</b></center></td>
<td><center><b>Cargo</b></center></td>
<td><center><b>Departamento</b></center></td>
<td><center><b>Local</b></center></td>
<td><center><b>E-mail</b></center></td>
<td><center><b>OU</b></center></td>
<td><center><b>Último login</b></center></td>
<td><center><b>Excluir</b></center></td>
<td><center><b>RF</b></center></td>
<td><center><b>Último FFI</b></center></td>
</tr>


<?php

include 'pesquisaFFI.php';
include "config.php";

$ldap_server = "ldap://10.10.65.242"; 
$dominio = "rede";

$auth_user = "rede\usr_smdu_Freenas"; 
$auth_pass = "Hta123P@"; 
$pessoa = array();
$smdu = array();
$sel = array();

$ultimadata = "";
$dias = "";

$GLOBALS['ID_Rede']="";


$base_dn = "OU=Users,OU=SMDU,DC=rede,DC=sp"; 

//$base_dn = "DC=rede,DC=sp"; 


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

$filter = "(&(objectClass=user)(objectCategory=person)(|(cn=$pesquisa)(samaccountname=$pesquisa))(!(userAccountControl:1.2.840.113556.1.4.803:=2))(memberOf=CN=G_X_VPN_PREFEITURA,OU=Groups,OU=PRODAM,DC=rede,DC=sp))";

//(memberOf=CN=G_X_VPN_PREFEITURA,OU=Groups,OU=PRODAM,DC=rede,DC=sp)


if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$GLOBALS['ID_Rede'] = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);

		$logon = $info[$i]["lastlogon"][0];		

		if (!($logon == "" || $logon == "0" || $logon == NULL)) {

			$ultimadata = date("d-m-Y", $logon/10000000-11644473600);

		
			$data_inicial = $ultimadata;
			$data_final = $data;

			// Calcula a diferença em segundos entre as datas
			$diferenca = strtotime($data_final) - strtotime($data_inicial);

			//Calcula a diferença em dias
			$dias = floor($diferenca / (60 * 60 * 24));

			}else{ $ultimadata = "Nunca";
		
		}


		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				//if ($dias<730) { $ultimologon =  $ultimadata.' - '.$dias.' dias'; }else{$ultimologon = ''; }

				$diasalto = $dias;
				$smdu += [$i => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'],
					'usuario' => $ID_Rede,
					'ultimologon' => $ultimadata,
					'diasalto' => $dias,
					'OU' => 'SMDU' )];
	
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
					'ultimologon' => $ultimadata,
					'diasalto' => $dias,
					'OU' => 'SMDU' )];
			}
 		}
 		}
	}
 }



// Fecha a conexao LDAP.

ldap_close($connect);

/*

$base_dn = "OU=Users,OU=ILUME,DC=rede,DC=sp"; 
//$base_dn = "DC=rede,DC=sp"; 


if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$GLOBALS['ID_Rede'] = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);

		$logon = $info[$i]["lastlogon"][0];


		if (!($logon == "" || $logon == "0" || $logon == NULL)) {

			$ultimadata = date("d-m-Y", $logon/10000000-11644473600);

		
			$data_inicial = $ultimadata;
			$data_final = $data;

			// Calcula a diferença em segundos entre as datas
			$diferenca = strtotime($data_final) - strtotime($data_inicial);

			//Calcula a diferença em dias
			$dias = floor($diferenca / (60 * 60 * 24));

			}else{ $ultimadata = "Nunca";
		
		}


		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				//if ($dias<730) { $ultimologon =  $ultimadata.' - '.$dias.' dias'; }else{$ultimologon = ''; }

				$diasalto = $dias;
				$ilume += [$i => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'],
					'usuario' => $ID_Rede,
					'ultimologon' => $ultimadata,
					'diasalto' => $dias,
					'OU' => 'ILUME' )];
	
				}
			}else if ($Nome != "" && $Email != ""){
				$ilume += [$i => array(
				    	'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'departamento' => '',
					'andar' => '',
					'Email' => mb_strtolower($Email),
					'usuario' => $ID_Rede,
					'ultimologon' => $ultimadata,
					'diasalto' => $dias,
					'OU' => 'ILUME' )];
		

		}
 		}
 		}
	}
 }

*/

// Fecha a conexao LDAP.

ldap_close($connect);
$base_dn = "OU=Users,OU=SEL,DC=rede,DC=sp"; 
//$base_dn = "DC=rede,DC=sp"; 


if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$GLOBALS['ID_Rede'] = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);

		$logon = $info[$i]["lastlogon"][0];


		if (!($logon == "" || $logon == "0" || $logon == NULL)) {

			$ultimadata = date("d-m-Y", $logon/10000000-11644473600);

		
			$data_inicial = $ultimadata;
			$data_final = $data;

			// Calcula a diferença em segundos entre as datas
			$diferenca = strtotime($data_final) - strtotime($data_inicial);

			//Calcula a diferença em dias
			$dias = floor($diferenca / (60 * 60 * 24));

			}else{ $ultimadata = "Nunca";
		
		}


		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				//if ($dias<730) { $ultimologon =  $ultimadata.' - '.$dias.' dias'; }else{$ultimologon = ''; }

				$diasalto = $dias;
				$sel += [$i => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'],
					'usuario' => $ID_Rede,
					'ultimologon' => $ultimadata,
					'diasalto' => $dias,
					'OU' => 'SEL' )];
	
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
					'ultimologon' => $ultimadata,
					'diasalto' => $dias,
					'OU' => 'SEL' )];
			}


 		}



 		sort($smdu);
 		sort($sel);
		//sort($ilume);

		$pessoa = array_merge($smdu, $sel);

		$result = count($pessoa);
		Echo "Foram encontrados " . $result . " pessoas nesta pesquisa.<br>";
		//sort($pessoa);
			for ($i=0; $i < $result; $i++){

			echo "<tr><td>".$pessoa[$i][usuario]."</td>";
				echo "<td>".$pessoa[$i][nome]."</td>";
				echo "<td>".$pessoa[$i][telefone]."</td>";
				echo "<td>".$pessoa[$i][cargo]."</td>";
				echo "<td>".$pessoa[$i][departamento]."</td>";
				echo "<td>".$pessoa[$i][andar]."</td>";
				echo "<td><a href=mailto:".$pessoa[$i][Email].">".$pessoa[$i][Email]."</a></td>";
				echo "<td><center>".$pessoa[$i][OU]."</td>";

		$ID = substr($pessoa[$i][usuario], 1);
		$NOME = $pessoa[$i][nome];
		$Tipo = substr($pessoa[$i][usuario], 0,-6);
		
 		if (!($pessoa[$i][ultimologon] == "Nunca")) {
				if ($pessoa[$i][diasalto] >= "60") { 
					echo "<td><font color=red><b><a href='http://intranet.smdu.pmsp/ass/pesquisa.uni.php?id=".$pessoa[$i][usuario]."&Nome=".$pessoa[$i][nome]."' onclick='abre();' target='verifica_IFRAME'>". $pessoa[$i][ultimologon]." - ". $pessoa[$i][diasalto]." dias</b></font></td>";
					echo "<td><font color=red>Atenção</font></td>";
					//echo "<td><center><input type=checkbox name=\"".$pessoa[$i][usuario]." - ".$pessoa[$i][nome]." - ".$pessoa[$i][Email]." \" value= \"(  ) Excluir\"><input type=button value=Excluir></center></td>";

				}else{ 	

						echo "<td>". $pessoa[$i][ultimologon]." - ". $pessoa[$i][diasalto]." dias</td>";
						echo "<td></td>";
				}
		}else{ 
			echo "<td><font color=red><b><a href='http://intranet.smdu.pmsp/ass/pesquisa.uni.php?id=".$pessoa[$i][usuario]."&Nome=".$pessoa[$i][nome]."' onclick='abre(); 'target='verifica_IFRAME'>". $pessoa[$i][ultimologon]."</b></font></td>";
			echo "<td><font color=red>Atenção</font></td>";
			//echo "<td><center><input type=checkbox name=\"".$pessoa[$i][usuario]." - ".$pessoa[$i][nome]." - ".$pessoa[$i][Email]." \" value= \"(  ) Excluir\"><input type=button value=Excluir></center></td>";

		}

		

  
		if ($Tipo == "x" || $Tipo == "X") {
			echo PesquisaEstagiario($NOME)."</tr>";

						// echo "<td colspan='2' > <center><font color=green><b>Estagiário</b></font></center></td>";
		}else{
			echo PesquisaFFI($ID)."</tr>";
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
</table>
<br><br>

Criado por Rogerio Fazio - 04/2020

</form>


<div id="posiciona"> 
<div id="fechar" align=right><a href="javascript:fechar();"><b>X</b></a></div> 
<iframe id="verifica_IFRAME" name="verifica_IFRAME" scrolling="auto" src="" width="800" height="300" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
</div>


</body>