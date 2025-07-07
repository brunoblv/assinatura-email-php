<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lista de conferencia de multiplos servidores DC.</title>
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
<center>
<?php echo "<br><font color=#ffffff>Pesquisa em todos os Servidores de AD da rede para: <b><font color=#ffffff>".$_GET['id']." - ".$_GET['Nome']."</font></b><br><br><font color=#000000>"; ?>


<table><tr>
<?php


$ldap_server = array(
		0 => "C68V48I",
		1 => "C53V10I",
		2 => "C53V11I",
		3 => "C53V12I");

$ldap_server2 = array(
		0 => "C64S213I", 
		1 => "C65V242I",
		2 => "C65V90I", 
		3 => "C65V91I");

$ldap_server3 = array(
		0 => "C68S42I", 
		1 => "C68V43I",
		2 => "C68V44I", 
		3 => "C68V45I");

$ldap_server4 = array(
		0 => "C68V46I",
		1 => "C68V47I",
		2 => "C68V49I",
		3 => "C66S85I");

$result = count($ldap_server);


for ($i=0; $i < $result; $i++){


$id = $_GET['id'];

echo "<td><center>Servidor: ".$ldap_server[$i]." <br> <iframe src='http://10.75.17.88/ass/pesquisa.uni.server.php?contato=".$id."&servidor=".$ldap_server[$i] ."' width='170px' height='20px' frameborder='2'></iframe></td>";


}

echo "</tr><tr>";

for ($i=0; $i < $result; $i++){


$contato = $_GET['contato'];

echo "<td><center>Servidor: ".$ldap_server2[$i]."<br> <iframe src='http://10.75.17.88/ass/pesquisa.uni.server.php?contato=".$id."&servidor=".$ldap_server2[$i] ."' width='170px' height='20px' frameborder='2'></iframe></td>";


}

echo "</tr><tr>";

for ($i=0; $i < $result; $i++){


$contato = $_GET['contato'];

echo "<td><center>Servidor: ".$ldap_server3[$i]." <br> <iframe src='http://10.75.17.88/ass/pesquisa.uni.server.php?contato=".$id."&servidor=".$ldap_server3[$i] ."' width='170px' height='20px' frameborder='2'></iframe></td>";


}

echo "</tr><tr>";

for ($i=0; $i < $result; $i++){


$contato = $_GET['contato'];

echo "<td><center>Servidor: ".$ldap_server4[$i]." <br> <iframe src='http://10.75.17.88/ass/pesquisa.uni.server.php?contato=".$id."&servidor=".$ldap_server4[$i] ."' width='170px' height='20px' frameborder='2'></iframe></td>";


}

echo "</tr>";
?>