<?php


function PesquisaFFI($ID) {
	
$db = mysql_connect("10.75.32.125","root","Hta123P");
$dado = mysql_select_db("SGU",$db);
	
$busca = mysql_query("Select distinct * from tblUsuarios where (cpRef like 'DAS%' or cpRef like 'DAI%' or cpRef = 'CHG' or cpRef like 'SM%') and cpRF LIKE '".$ID."%'
union
Select distinct * from tblUsuarios where not cpRF in (Select cpRF from tblUsuarios where (cpRef like 'DAS%' or cpRef like 'DAI%' or cpRef = 'CHG' or cpRef like 'SM%')) and cpRF LIKE '".$ID."%'
order by cpUnid, cpNome"); 

if (mysql_num_rows($busca)>0) {
	while ($dados = mysql_fetch_array($busca)) {
		
		echo "<td>".$dados['cpRF']."</td>";
		if ($dados['cpUltimaCarga'] == "x") { 
		echo "<td></td>";
		}else{
		 echo "<td> <center><font color=red><b>EXCLUIR</b></font></center></td>";
		}

		

}
}else{
			 echo "<td colspan='2' > <center><font color=red><b>NÃO CONSTA</b></font></center></td>";
}


mysql_close($db);
}

function PesquisaEstagiario($ID) {
	
$db = mysql_connect("10.75.32.125","root","Hta123P");
$dado = mysql_select_db("estagiarios",$db);
	
$busca = mysql_query("SELECT nome, login, desligado FROM tab_cad_estagiarios WHERE nome = '".$ID."'");

if (mysql_num_rows($busca)>0) {
	while ($dados = mysql_fetch_array($busca)) {
		
		if ($dados['desligado'] > 0) { 
			echo "<td colspan='2' > <center><font color=red><b>EXCLUIR ESTAGIÁRIO</b></font></center></td>";
		}else{
			echo "<td colspan='2' > <center><font color=green><b>ESTAGIÁRIO</b></font></center></td>";
		}

	}
}else{
			 echo "<td colspan='2' > <center><font color=red><b>ESTAGIÁRIO NÃO CONSTA</b></font></center></td>";
}


mysql_close($db);
}
//echo PesquisaFFI(827);