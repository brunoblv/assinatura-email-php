<html>    
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

             
        
<?php 


date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y H:i');
$date2 = date('d-m-Y_H.i');


   // Determina que o arquivo é uma planilha do Excel
   header("Content-type: application/vnd.ms-excel");   

   // Força o download do arquivo
   header("Content-type: application/force-download");  

   // Seta o nome do arquivo
   header("Content-Disposition: attachment; filename=Servidores_SMUL_".$date2.".xls");

   header("Pragma: no-cache");
   
  include "config.php";
  
  $inicial = $_GET['contato'];

$ldap_server = "ldap://10.10.65.242"; 
$dominio = "rede";

$auth_user = "rede\usr_smdu_Freenas"; 
$auth_pass = "Prodam01";
$pessoa = array();
$SMDU = array();
$SEL = array();



$base_dn = "OU=Users,OU=SMUL,DC=rede,DC=sp"; 

$pesquisa = $_GET['contato'];


$filter = "(&(objectClass=user)(objectCategory=person)(|(cn=$pesquisa*)(samaccountname=$pesquisa*))(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";




$html = "
<table border=1px cellpadding=5px cellspacing=0>
<tr>
<td colspan=6><font size=16><center><b>SMUL - Secretaria Municipal de Urbanismo e Licenciamento</cente></b></td>
<td><center><b>Emitido em: ".$date."</b></center></td>
</tr>


<td><center><b></b></center></td>
<td><center><b>Nome</b></center></td>
<td><center><b>Telefone</b></center></td>
<td><center><b>Cargo</b></center></td>
<td><center><b>Departamento</b></center></td>
<td><center><b>Local</b></center></td>
<td><center><b>E-mail</b></center></td>
</tr>
";

if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);
		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				$SMDU += [$i => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'])];
	
				}
			}else if ($Nome != "" && $Email != ""){
				$SMDU += [$i => array(
				    'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'departamento' => '',
					'andar' => '',
					'Email' => mb_strtolower($Email))];

			}


 		}
 		





 		}



	}

mysql_close($db);

 }



// Fecha a conexao LDAP.
ldap_close($connect);


$base_dn = "OU=Users,OU=SMUL,DC=rede,DC=sp"; 


if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$Nome = utf8_encode($info[$i]["displayname"][0]);
		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '$ID_Rede' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				$SEL += [$i => array(
					'nome' => $dados['cp_nome'],
					'telefone' => $dados['cp_telefone'],
					'cargo' => $dados['cp_cargo'],
					'departamento' => $dados['cp_departamento'],
					'andar' => $dados['cp_andar'],
					'Email' => $dados['cp_email'])];
	
				}
			}else if ($Nome != "" && $Email != ""){
				$SEL += [$i => array(
				    'nome' => $Nome,
					'telefone' => '',
					'cargo' => '',
					'departamento' => '',
					'andar' => '',
					'Email' => mb_strtolower($Email))];

			}


 		}
 		

		$pessoa = array_merge($SMDU, $SEL);

		$result = count($pessoa);
		//Echo "Foram encontrados " . $result . " pessoas nesta pesquisa.<br><br><br>";
		sort($pessoa);
			for ($i=0; $i < $result; $i++){
				$html = $html."
				<tr><td><center>". ($i+1) ."</center></td>
				<td>".$pessoa[$i][nome]."</td>
				<td>".$pessoa[$i][telefone]."</td>
				<td>".$pessoa[$i][cargo]."</td>
				<td>".$pessoa[$i][departamento]."</td>
				<td>".$pessoa[$i][andar]."</td>
				<td><a href=mailto:".$pessoa[$i][Email].">".$pessoa[$i][Email]."</td></a>";
			}

		echo $html;


 		}



	}



 }



// Fecha a conexao LDAP.
ldap_close($connect);





mysql_close($db);
?>
</table>