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
  
  $inicial = $_GET['contato'];

$busca = mysql_query("select * from tbl_telefones WHERE cp_nome LIKE '%$inicial%' OR cp_cargo LIKE '%$inicial%' OR cp_departamento LIKE '%$inicial%' ORDER BY cp_nome ASC"); 
?>
<table border="1px" cellpadding="5px" cellspacing="0">

<td><center><b>Nome</b></center></td>
<td><center><b>Telefone</b></center></td>
<td><center><b>Cargo</b></center></td>
<td><center><b>Departamento</b></center></td>
<td><center><b>Local</b></center></td>
<td><center><b>E-mail</b></center></td>
</tr>
<?php
$total = mysql_num_rows($busca);
if(mysql_num_rows($busca)>0) {
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