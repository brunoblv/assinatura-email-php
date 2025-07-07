<?php
// -------------- CHANGE VARIABLES TO SUIT YOUR ENVIRONMENT  --------------
//LDAP server address
$server = "ldap://10.10.65.242";

$user = $_REQUEST['usuario']."@rede.sp";

$psw = $_POST['senha'];
//domain user to connect to LDAP
//$user = "d827520@rede.sp";
//echo $psw;
//user password
//$psw = "sss";

//FQDN path where search will be performed. OU - organizational unit / DC - domain component
$dn = "OU=Users,OU=SMDU,DC=rede,DC=sp";

//Search query. CN - common name (CN=* will return all objects)
$search = "userprincipalname=".$user;                    
// ------------------------------------------------------------------------

echo "<h2>php LDAP query test</h2>";
// connecting to LDAP server
$ds=ldap_connect($server);
$r=ldap_bind($ds, $user , $psw); 

// performing search
$sr=ldap_search($ds, $dn, $search);
$data = ldap_get_entries($ds, $sr);    
echo "Found " . $data["count"] . " entries";
for ($i=0; $i<$data["count"]; $i++) {
	
 echo "<strong>Nome: </strong>" . $data[$i]["givenname"][0] . "</h4><br />";
 echo "<strong>Sobrenome: </strong>" . $data[$i]["sn"][0] . "</h4><br />";
 echo "<strong>E-mail: </strong>" . $data[$i]["mailnickname"][0] . "</h4><br />";
 
 
 
 
 
 echo "<h4><strong>Common Name: </strong>" . $data[$i]["cn"][0] . "</h4><br />";
 echo "<strong>Distinguished Name: </strong>" . $data[$i]["dn"] . "<br />";
 echo "<strong>Desription: </strong>" . print_r(array_values ($data[$i])) . "<br />";

echo "<strong>TESTE: </strong>" . $data[$i]["physicaldeliveryofficename"][0] . "</h4><br />";

echo "<strong>TESTE: </strong>" . $data[$i]["telephonenumber"][0] . "</h4><br />";

echo "<strong>Nome: </strong>" . $data[$i]["givenname"][0] . "</h4><br />";

 


 //checking if discription exists 
 if (isset($data[$i]["description"][0])) 
 echo "<strong>Desription: </strong>" . $data[$i]["description"][0] . "<br />";
 else 
 echo "<strong>Description not set</strong><br />";
 //checking if email exists
 if (isset($data[$i]["mail"][0]))
 echo "<strong>Email: </strong>" . $data[$i]["mail"][0] . "<br /><hr />";
 else 
 echo "<strong>Email not set</strong><br /><hr />";
 }
 // close connection
 ldap_close($ds);
?>