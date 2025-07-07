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

<table border="1px" cellpadding="5px" cellspacing="0">

<td><center><b>Nome</b></center></td>
<td><center><b>Telefone</b></center></td>
<td><center><b>Cargo</b></center></td>
<td><center><b>Departamento</b></center></td>
<td><center><b>Local</b></center></td>
<td><center><b>E-mail</b></center></td>
</tr>


<?php

include "config.php";

$ldap_server = "ldap://10.10.65.242"; 
$dominio = "rede";

$auth_user = "rede\d827520"; 
$auth_pass = "AveMaria-01"; 


// Caminho LDAP do Dominio
$base_dn = "OU=Users,OU=SMDU,DC=rede,DC=sp"; 

// Caminho LDAP do Grupo para consulta
//$filter = "(&(objectClass=user)(memberOf=CN=grupo,OU=ou_do_grupo,OU=ou_principal,DC=seudominio,DC=com,DC=br))";
//(&(objectCategory=Person)(sAMAccountName=*)(|(memberOf=cn=fire,ou=users,dc=company,dc=com)(memberOf=cn=wind,ou=users,dc=company,dc=com)(memberOf=cn=water,ou=users,dc=company,dc=com)(memberOf=cn=heart,ou=users,dc=company,dc=com)))


$filter = "(&(objectClass=user)(objectCategory=person)(cn=*)(samaccountname=$usuario*)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";

//Funcao para conectar na base LDAP listar os usuarios de um grupo.

if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);

		for ($i=0; $i < $info["count"]; $i++){

		$ID_Rede = $info[$i]["samaccountname"][0];
		$Email = $info[$i]["mail"][0];
		$busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '%$ID_Rede%' ORDER BY cp_nome ASC"); 

			if (mysql_num_rows($busca)>0) {
				while ($dados = mysql_fetch_array($busca)) {
				echo "<tr>";
				echo "<td>".$dados['cp_nome']."</td>";
				echo "<td>".$dados['cp_telefone']."</td>";
				echo "<td>".$dados['cp_cargo']."</td>";
				echo "<td>".$dados['cp_departamento']."</td>";
				echo "<td>".$dados['cp_andar']."</td>";
				echo "<td><a href=mailto:".$dados['cp_email'].">".$dados['cp_email']."</td></a>";	
				}
			}else if ($Email != ""){
    				echo "<tr>";
				echo "<td>" . utf8_encode($info[$i]["displayname"][0]) . "</td>";
    				echo "<td colspan=4> </td>";
  				echo "<td><a href=mailto:". $Email .">". $Email ."</a></td></tr>";
			} 

 		}
 		}

	}

}
// Fecha a conexao LDAP.
ldap_close($connect);

echo "<tr><td colspan=6> <center><BR><BR><b>SEL</b><BR><BR></center></td>";

echo "</tr>";



$ldap_server = "ldap://10.10.65.242"; 
$dominio = "rede";

$auth_user = "rede\d827520"; 
$auth_pass = "AveMaria-01"; 


// Caminho LDAP do Dominio
$base_dn = "OU=Users,OU=SEL,DC=rede,DC=sp"; 

// Caminho LDAP do Grupo para consulta
//$filter = "(&(objectClass=user)(memberOf=CN=grupo,OU=ou_do_grupo,OU=ou_principal,DC=seudominio,DC=com,DC=br))";

$filter = "(&(objectClass=user)(objectCategory=person)(cn=*)(samaccountname=$usuario*)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";

//Funcao para conectar na base LDAP listar os usuarios de um grupo.

if (($connect=@ldap_connect($ldap_server))) {
 if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {
 if (($search=@ldap_search($connect, $base_dn, $filter))){
 $number_returned = ldap_count_entries($connect,$search);
 $info = ldap_get_entries($connect, $search);



   for ($i=0; $i < $info["count"]; $i++){

     $ID_Rede = $info[$i]["samaccountname"][0];
	$Email = $info[$i]["mail"][0];


     $busca = mysql_query("select * from tbl_telefones WHERE cp_usuario_rede LIKE '%$ID_Rede%' ORDER BY cp_nome ASC"); 

if (mysql_num_rows($busca)>0) {
	while ($dados = mysql_fetch_array($busca)) {
	echo "<tr>";
	echo "<td>".$dados['cp_nome']."</td>";
	echo "<td>".$dados['cp_telefone']."</td>";
	echo "<td>".$dados['cp_cargo']."</td>";
	echo "<td>".$dados['cp_departamento']."</td>";
	echo "<td>".$dados['cp_andar']."</td>";
	echo "<td><a href=mailto:".$dados['cp_email'].">".$dados['cp_email']."</td></a>";	
	}
}else if ($Email != ""){
    	echo "<tr>";
	echo "<td>" . utf8_encode($info[$i]["displayname"][0]) . "</td>";
    	echo "<td colspan=4> </td>";
  	echo "<td><a a href=mailto:". $Email .">". $Email ."</a></td></tr>";
 } 




   }



mysql_close($db);

 }

 }

}
// Fecha a conexao LDAP.
ldap_close($connect);
?>