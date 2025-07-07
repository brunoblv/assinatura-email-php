
<style type="text/css">


        BODY{
        font-family: Calibri;
        } 
.topo{
 height:15.0pt;
 font-size:11.0pt;
  color:white;
  font-weight:700;
  text-decoration:none;
  text-underline-style:none;
  text-line-through:none;
  font-family:Calibri;
  border-top:.5pt solid #000000;
  border-right:none;
  border-bottom:.5pt solid #000000;
  border-left:.5pt solid #000000;
  background:#000000;
  mso-pattern:#000000 none;
   }

.row1{
    height:15.0pt;font-size:11.0pt;
  font-weight:400;
  text-decoration:none;
  text-underline-style:none;
  text-line-through:none;
  font-family:Calibri;
  border-top:.5pt solid #95B3D7;
  border-right:.5pt solid windowtext;
  border-bottom:.5pt solid #95B3D7;
  border-left:.5pt solid windowtext
}

.row2{
height:15.0pt;
font-size:11.0pt;
  font-weight:400;
  text-decoration:none;
  text-underline-style:none;
  text-line-through:none;
  font-family:Calibri;
  border-top:.5pt solid #95B3D7;
  border-right:.5pt solid windowtext;
  border-bottom:.5pt solid #95B3D7;
  border-left:.5pt solid windowtext;
  mso-pattern:#DCE6F1 none;
}

.hoje{
height:15.0pt;
font-size:11.0pt;
  font-weight:400;
  color: white;
  text-decoration:none;
  text-underline-style:none;
  text-line-through:none;
  font-family:Calibri;
  border-top:.5pt solid #95B3D7;
  border-right:.5pt solid windowtext;
  border-bottom:.5pt solid #95B3D7;
  border-left:.5pt solid windowtext;
  background:#FF4500;
  mso-pattern:#DCE6F1 none;

}
A:link{color:#000000}

A:visited{color:#0000C0}
</style> 
<body TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0 text="#000000" style="background-repeat:no-repeat;" bgproperties="fixed" background="img/baloes1.jpg" >
<?php
include "config.php";

 $mes = date('m'); //Gera mes em formato numérico
 $dia = date('d-3'); //Gera mes em formato numérico
 $hoje = date('d'); //Gera mes em formato numérico

//compara os meses numericos pra gerar os meses escritos - inicio
 if ($mes=='01') {$mes_escrito='Janeiro';}
 if ($mes=='02') {$mes_escrito='Fevereiro';}
 if ($mes=='03') {$mes_escrito='Março';}
 if ($mes=='04') {$mes_escrito='Abril';}
 if ($mes=='05') {$mes_escrito='Maio';}
 if ($mes=='06') {$mes_escrito='Junho';}
 if ($mes=='07') {$mes_escrito='Julho';}
 if ($mes=='08') {$mes_escrito='Agosto';}
 if ($mes=='09') {$mes_escrito='Setembro';}
 if ($mes=='10') {$mes_escrito='Outubro';}
 if ($mes=='11') {$mes_escrito='Novembro';}
 if ($mes=='12') {$mes_escrito='Dezembro';}
 //compara os meses numericos pra gerar os meses escritos - fim

echo "<center><font size=2 size='Calibri'><b>Aniversários de $mes_escrito</b></font></center>"; //mostra o mês corrente

$busca = mysql_query("select * from tbl_telefones where cp_nasc_mes like $mes AND cp_nasc_dia > $dia order by cp_nasc_dia asc") or trigger_error('Erro ao executar consutla. Detalhes = ' . mysql_error());


//echo $busca;


if (empty($busca)) { //Se nao achar nada, lança essa mensagem
    echo "<table>";
	echo "<tr>";
	echo "<td>" ;
    echo "Nenhum registro encontrado.";

	echo "</td>";
	echo "</tr>";
	echo "</table>";
	}

// quando existir algo em '$busca' ele realizará o script abaixo.
echo "<table align=center>";
    echo "<tr class=topo>";
        echo "<td width=10>";
            echo "Dia";
	echo "<td width=140>";
            echo "<font size=2>Nome</font>";
        echo "</td>";
    echo "</tr>";

while ($dados = mysql_fetch_array($busca)) {

    $estilo = ((++$i % 2) == 0) ? 'row1' : 'row2';
    if ($dados[cp_nasc_dia] == $hoje) {$estilo = 'hoje';}

echo "<tr class=\"{$estilo}\">";
	echo "<td width=10 valign=top>";
            echo "<font size=2><center>$dados[cp_nasc_dia]</center></font>";
	echo "</td>";

        echo "<td valign=top>";
            echo "<b><a href=mailto:$dados[cp_email]><font size=2>$dados[cp_nome]</font></a><br>";
            echo "<font size=2>$dados[cp_departamento] -$dados[cp_andar]</font>";
        echo "</td>";
    echo "</tr>";
}
echo "</table>";

mysql_close($db);
?>

<br>