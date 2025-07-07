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

   // Determina que o arquivo é uma planilha do Excel
   header("Content-type: application/vnd.ms-excel");   

   // Força o download do arquivo
   header("Content-type: application/force-download");  

   // Seta o nome do arquivo
   header("Content-Disposition: attachment; filename=Servidores_SMUL.xls");

   header("Pragma: no-cache");
   
  include "config.php";
  
  $inicial = $_GET['contato'];

$busca = mysql_query("select * from tbl_telefones WHERE cp_nome LIKE '%$inicial%' ORDER BY cp_nome ASC"); 


$html = "
<table border=1px cellpadding=5px cellspacing=0>
<td><center><b>Nome</b></center></td>
<td><center><b>Telefone</b></center></td>
<td><center><b>Cargo</b></center></td>
<td><center><b>Departamento</b></center></td>
<td><center><b>Local</b></center></td>
<td><center><b>E-mail</b></center></td>
</tr>
";

if(mysql_num_rows($busca)>0) {
	while ($dados = mysql_fetch_array($busca)) {
    $html = $html."<tr>
			<td>".$dados['cp_nome']."</td>
			<td>".$dados['cp_telefone']."</td>
			<td>".$dados['cp_cargo']."</td>
			<td>".$dados['cp_departamento']."</td>
			<td>".$dados['cp_andar']."</td>
			<td><a a href=mailto:".$dados['cp_email'].">".$dados['cp_email']."</td></a>";	

	}
        
		echo $html;

}else{
	echo "<h1>Esta pesquisa não gerou nenhum resultado.</h1>";
}	

mysql_close($db);
?>
</table>