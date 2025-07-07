<meta http-equiv="Cache-control" content="no-cache">
<style type="text/css">


        BODY{
		margin:0 0;
        font-family: Roboto, sans-serif;
		 background:#ffffff;
        } 
.topo{
 height:15.0pt;
 font-size:11.0pt;
  color:white;
  font-weight:700;
  text-decoration:none;
  text-underline-style:none;
  text-line-through:none;
  font-family:Roboto, sans-serif;
  border-top:.5pt solid #000000;
  border-right:none;
  border-bottom:.5pt solid #000000;
  border-left:.5pt solid #000000;
  background:#000000;
  mso-pattern:#000000 none;
   }

.row1{
    height:15.0pt;font-size: 13px;
    background:#ebebebeb;
  font-weight:400;
  text-decoration:none;
  text-underline-style:none;
  text-line-through:none;
  font-family:Roboto, sans-serif;
  border-top:.5pt solid #95B3D7;
  border-right:.5pt solid windowtext;
  border-bottom:.5pt solid #95B3D7;
  border-left:.5pt solid windowtext
}

.row2{
height:15.0pt;
font-size: 13px;
  font-weight:400;
  text-decoration:none;
  text-underline-style:none;
  text-line-through:none;
  font-family:Roboto, sans-serif;
  border-top:.5pt solid #95B3D7;
  border-right:.5pt solid windowtext;
  border-bottom:.5pt solid #95B3D7;
  border-left:.5pt solid windowtext;
  mso-pattern:#DCE6F1 none;
}

.hoje{
height:15.0pt;
font-size: 13px;
  font-weight:400;
  color: black;
  text-decoration:none;
  text-underline-style:none;
  text-line-through:none;
  font-family:Roboto, sans-serif;
  border-top:.5pt solid #95B3D7;
  border-right:.5pt solid windowtext;
  border-bottom:.5pt solid #95B3D7;
  border-left:.5pt solid windowtext;
  background:#d4defb;
  mso-pattern:#DCE6F1 none;

}
A:link{color:#000000}

A:visited{color:#0000C0}
</style> 
<body TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0 text="#0a3299" style="background-repeat:no-repeat;" bgproperties="fixed" background="" >
<?php
include "config.php";

 $mes = date('m'); //Gera mes em formato numérico
 $dia = date('d-3'); //Gera mes em formato numérico
 $hoje = date('d'); //Gera mes em formato numérico

//compara os meses numericos pra gerar os meses escritos - inicio
 if ($mes=='01') {$mes_escrito='JANEIRO';}
 if ($mes=='02') {$mes_escrito='FEVEREIRO';}
 if ($mes=='03') {$mes_escrito='MARÇO';}
 if ($mes=='04') {$mes_escrito='ABRIL';}
 if ($mes=='05') {$mes_escrito='MAIO';}
 if ($mes=='06') {$mes_escrito='JUNHO';}
 if ($mes=='07') {$mes_escrito='JULHO';}
 if ($mes=='08') {$mes_escrito='AGOSTO';}
 if ($mes=='09') {$mes_escrito='SETEMBRO';}
 if ($mes=='10') {$mes_escrito='OUTUBRO';}
 if ($mes=='11') {$mes_escrito='NOVEMBRO';}
 if ($mes=='12') {$mes_escrito='DEZEMBRO';}
 //compara os meses numericos pra gerar os meses escritos - fim

echo "<table><tr class=\"aniversarios-titulo\"><td width='30px'><img src='img/balao3.png' width='25px'></td><td style='font-family: Roboto, sans-serf; font-size: 13px; font-weight: 900; color: #0a3299'>ANIVERSARIANTES DE $mes_escrito</td></tr></table>"; //mostra o mês corrente

$busca = mysqli_query($mysqli, "select * from tbl_telefones where cp_nasc_mes like $mes AND cp_nasc_dia > $dia order by cp_nasc_dia asc") or trigger_error('Erro ao executar consutla. Detalhes = ' . mysqli_error());


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
//    echo "<tr class=topo>";
//        echo "<td width=10>";
//            echo "Dia";
//	echo "<td width=140>";
//            echo "<font size=2>Nome</font>";
//        echo "</td>";
//    echo "</tr>";

$i = 0;

while ($dados = mysqli_fetch_array($busca)) {

    $estilo = (($i++ % 2) == 0) ? 'row1' : 'row2';
    if ($dados['cp_nasc_dia'] == $hoje) {$estilo = 'hoje';}
	
	$dia =  $dados['cp_nasc_dia'];
	$dia =  str_pad($dia, 2, 0, STR_PAD_LEFT);
	

echo "<tr class=\"{$estilo}\">";
	echo "<td width=10 valign=top>";
            echo "<font ";
			if ($dados['cp_nasc_dia'] == $hoje) 
				{ echo 'color = #0a3299';
				}else{ echo 'color = #0a3299';
				}
			
			echo "><center><b>$dia</b></center></font>";
	echo "</td>";

        echo "<td valign=top>";
            echo "<b><a href=mailto:$dados[cp_email]><font ";
			
			if ($dados['cp_nasc_dia'] == $hoje) 
				{ echo 'color = #0a3299';
				}else{ echo 'color = ##0a3299';
				}
			
			echo ">$dados[cp_nome]</font></a><br>";
            echo "<font>$dados[cp_departamento] </font>";
        echo "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($mysqli);
?>

<br>
