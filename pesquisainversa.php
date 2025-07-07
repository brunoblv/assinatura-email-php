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
  include "config.php";
  

$ldap_server = "ldap://10.10.65.242"; 
$dominio = "rede";

$auth_user = "rede\usr_smdu_Freenas"; 
$auth_pass = "Hta123P@"; 
$pessoa = array();


$base_dn = "OU=Users,OU=SMDU,DC=rede,DC=sp"; 


  $inicial = $_GET['contato'];

$busca = mysql_query("select * from tbl_telefones WHERE cp_nome LIKE '%$inicial%' OR cp_cargo LIKE '%$inicial%' OR cp_departamento LIKE '%$inicial%' ORDER BY cp_nome ASC"); 

if (mysql_num_rows($busca)>0) {

$pesquisa = $_GET['contato'];

$base_dn = "DC=rede,DC=sp"; 

$filter = "(&(objectClass=user)(objectCategory=person)(|(cn=$pesquisa*)(samaccountname=$pesquisa*))(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";

if (($connect=@ldap_connect($ldap_server))) {
	if (($bind=@ldap_bind($connect, $auth_user, $auth_pass))) {

		if (($search=@ldap_search($connect, $base_dn, $filter))){

		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);


if(mysql_num_rows($busca)>0 && $info["count"]==0) {
	while ($dados = mysql_fetch_array($busca)) {
    echo "<tr>";
	echo "<td>".$dados['cp_nome']."</td>";
    echo "<td>".$dados['cp_telefone']."</td>";
	echo "<td>".$dados['cp_cargo']."</td>";
	echo "<td>".$dados['cp_departamento']."</td>";
  	echo "<td>".$dados['cp_andar']."</td>";
  	echo "<td><a a href=mailto:".$dados['cp_email'].">".$dados['cp_email']."</td></a>";	
	}
}else{
	echo "<h1>Esta pesquisa não gerou nenhum resultado.</h1>";
}	
echo "</table>";
mysql_close($db);
?>
</table>
 <?php echo "Total de registros: ".$total;?>