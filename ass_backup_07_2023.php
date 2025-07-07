<?php 
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, cachehack=".time());
header("Cache-Control: no-store, must-revalidate");
header("Cache-Control: post-check=-1, pre-check=-1", false); 
?>

<html>    
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php header("Content-type: text/html; charset=utf-8");

if(empty($_REQUEST)) 
	header("Location: index.php");


include "config.php";



if(isset($_GET['n'])):

$inicial = $_REQUEST['usr'];


$busca = mysql_query("select * from tbl_telefones where cp_usuario_rede='$inicial'") or trigger_error('Erro ao executar consutla. Detalhes = ' . mysql_error());

if(mysql_num_rows($busca)>0) {
	while ($dados = mysql_fetch_array($busca)) {
	$bd_nome = $dados['cp_nome'];
	$bd_secretaria = $dados['cp_secretaria'];
	$bd_tel = $dados['cp_telefone'];
	$bd_cargo = $dados['cp_cargo'];
	$bd_departamento = $dados['cp_departamento'];  // ***************LIBERAR DEPOIS DE TUDO PADRONIZADO***************
  	$bd_andar = $dados['cp_andar'];
  	$bd_email = $dados['cp_email'];
	$bd_site = $dados['cp_site'];

	}
	echo '<font face=Calibri >
		<center>
		<h1>2º Por favor confira as informações e copie a assinatura em HTML abaixo selecionando, copiando e colando no seu Outlook.</h1>
<br>
<br>
<table>
<tr>
	<td width="150px">
    		&nbsp; &nbsp; &nbsp; &nbsp; <img src=img/'.$bd_secretaria.'/ass.png width=130px > &nbsp; &nbsp; &nbsp; &nbsp;
		
	<td width=1px bgcolor="#000000"></td>
			
	<td style="padding-left: 10px;" width=350px>
			<font face=Calibri size=3><b>'.$bd_nome.'</b><br></font>
			<font face=Calibri size=2>'.$bd_cargo.'<br>
			'.$bd_secretaria.' - '.$bd_departamento.'
			<br>
			+55 (11) '.$bd_tel.'
			<br>
			<a href=mailto:'.$bd_email.'>'.$bd_email.'</a><br>
			<br>
			<pre><font face=Calibri>'.$bd_andar.'</pre>

			<a href='.$bd_site.'>'.$bd_site.'</a><br>

	<span style="background-color: rgb(255, 255, 255); display: inline !important; color: rgb(10, 50, 153);">Siga a</span><b style="background-color:rgb(255, 255, 255)"><span style="color: rgb(10, 50, 153);">&nbsp;</span></b><span style="color: rgb(10, 50, 153);"><b style="background-color:rgb(255, 255, 255)">@smul_sp</b></span><span style="background-color:rgb(255, 255, 255);display:inline !important"><span style="color: rgb(10, 50, 153);">&nbsp;</span></span><span style="background-color: rgb(255, 255, 255); display: inline !important; color: rgb(10, 50, 153);">nas
	 redes sociais!</span><br>
	 <span style="color: rgb(10, 50, 153);"><a href="https://www.facebook.com/smulsp" target="FB">Facebook</a> | <a href="https://www.instagram.com/smul_sp/" target="Inatagram">Instagram</a> | <a href="https://twitter.com/smul_sp" target="Twitter">Twitter</a></span>

	</td>
</tr>
</table><br><br><br>
	';
	
}else{
	$bd_nome = "";
	$bd_tel = "";
	$bd_cargo = "";
	$bd_departamento = "";
  	$bd_andar = "";
  	$bd_email = "";
	$bd_dia = "";
	$bd_mes = "";
}



mysql_close($db);


$img = urldecode( $_GET['n'] );
echo '
<html>
<head>
</head>
<body>
<font face="Calibri">
<center>


<h1>Ou clique na imagem para iniciar o download:</h1>
<a href="download.php?file='.$img.'"><img src="'.$img.'" border=10></a><br>

';

?>
<?php else:?>
<?php 

include "config.php";

$server = "ldap://10.10.65.242";

$ID_Usuario=mb_strtolower($_REQUEST['usuario'],'UTF-8');

$user = $_REQUEST['usuario']."@rede.sp";

$psw = $_REQUEST['senha'];



$inicial = $_REQUEST['usuario'];

//$dn = "OU=Users,OU=SMUL,DC=rede,DC=sp";
$dn = "DC=rede,DC=sp";

$search = "samaccountname=".$_REQUEST['usuario'];  //"samaccountname=".$user; ou userprincipalname //

$ds=ldap_connect($server);
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3); // Corrige problema com "ç"
$r=ldap_bind($ds, $user , $psw); 

$sr=ldap_search($ds, $dn, $search);
$data = ldap_get_entries($ds, $sr); 



if($data["count"]==0) header("Location: index.php?m=erro");

for ($i=0; $i<$data["count"]; $i++) {
 $nomefr = utf8_encode($data[$i]["givenname"][0]);
 $sobrenomefr = utf8_encode($data[$i]["sn"][0]);
 $emailfr = mb_strtolower($data[$i]["mail"][0]);
}


$busca = mysql_query("select * from tbl_telefones where cp_usuario_rede='$inicial'") or trigger_error('Erro ao executar consutla. Detalhes = ' . mysql_error());

if(mysql_num_rows($busca)>0) {
	while ($dados = mysql_fetch_array($busca)) {
	$bd_tel = $dados['cp_telefone'];
	$bd_cargo = $dados['cp_cargo'];
	$bd_departamento = $dados['cp_departamento'];  // ***************LIBERAR DEPOIS DE TUDO PADRONIZADO***************
  	$bd_andar = $dados['cp_andar'];
  	$bd_email = $dados['cp_email'];
	$bd_dia = $dados['cp_nasc_dia'];
	$bd_mes = $dados['cp_nasc_mes'];
	}
}else{
	$bd_tel = "";
	$bd_cargo = "";
	$bd_departamento = "";
  	$bd_andar = "";
  	$bd_email = "";
	$bd_dia = "";
	$bd_mes = "";
}


mysql_close($db);


?>


<html>
<script type="text/javascript" language="javascript">
	function formatar_mascara(src, mascara) {
		var campo = src.value.length;
		var saida = mascara.substring(0,1);
		var texto = mascara.substring(campo);
		if(texto.substring(0,1) != saida) {
			src.value += texto.substring(0,1);
		}
	}
	function assina(){			
		var nome=ass.nome.value;
		var cargo=ass.cargo.value;
		var departamento=ass.departamento.value;
		var email=ass.email.value;
		var t1=ass.t1.value;

		var telefone;
		var div = document.getElementById("divResultado");
		var p = document.getElementById("nomeResultado");
		
		if((nome==null||nome=="")||(cargo==null||cargo=="")||(departamento==null||departamento=="")||(email==null||email=="")){
			alert('Por Favor preencha todos os campos!');
		}else{
			if((t1==null||t1=="")&&(t1==t2)){
				p.innerText=(nome);
				div.innerText=(+cargo+"\n"+departamento+"\n"+email);
			}else if ((t2==null||t2=="")&&(t1!=t2)){
				telefone=t1;
				p.innerText=(nome);
				div.innerText=(cargo+"\n"+departamento+"\n"+telefone+" | "+email);
			}else if ((t1==null||t1=="")&&(t1!=t2)){
				telefone=t2;
				p.innerText=(nome);
				div.innerText=(cargo+"\n"+departamento+"\n"+telefone+" | "+email);
			}
				
		}

		
	}
	
	
</script>

<head>

<style type="text/css">

	#posiciona {
	display: none;
        position: fixed; /* posição absoluta ao elemento pai, neste caso o BODY */
        /* Posiciona no meio, tanto em relação a esquerda como ao topo */
        left: 50%; 
        top: 50%;
        width: 800px; /* Largura da DIV */
        height: 350px; /* Altura da DIV */
        /* A margem a esquerda deve ser menos a metade da largura */
        /* A margem ao topo deve ser menos a metade da altura */
        /* Fazendo isso, centralizará a DIV */
        margin-left: -400px;
        margin-top: -200px;
        background-color: #FFF;
        color: #FFF;
        background-color: #666;
        text-align: center; /* Centraliza o texto */
        z-index: 1000; /* Faz com que fique sobre todos os elementos da página */
    }
    #fechar { margin: 5px; font-size: 12px; }
	  </style>
	
<script>
       function mudaimagem(item) {
               var img = document.getElementById('imagens');
               img.innerHTML = '<img src="img/' + item + '/logo.png" width=200px >';

			   document.getElementById('site').value='http://'+item.toLowerCase()+'.prefeitura.sp.gov.br/';
			   
       }
</script>


</head>
<body>
<font face="Calibri">
<center>
			<h1>1º Para criar a assinatura de e-mail, favor preencher os itens abaixo:</h1>
<form name="ass" action="./gera_img.php" method="post">
<table>
	<tr>
			<td>

				
		</td>
		<td>
				<p>Secretaria:		</td> <td><select id="secretaria" name="secretaria" onChange="mudaimagem(this.value);" required="required">
   				<option value=""></option>
    			<option value="SMUL">SMUL - Secretaria Municipal de Urbanismo e Licenciamento</option>
				<!--<option value="PSUrb">SP Urbanismo</option>-->
    			<!--<option value="SMADS">SMADS - Secretaria Municipal de Assistência e Desenvolvimento Social </option>-->
				</select>
		</td>

		<td>
		
		</td>
	</tr>
	<tr>
		<td  rowspan="9" width="200px" style="padding-top: 10px;padding-right: 10px;padding-left: 10px;padding-bottom: 10px;border-top-width: 0px;border-top-style: solid;border-bottom-width: 0px;border-bottom-style: solid;border-right-width: 0px;border-right-style: solid;border-left-width: 0px;border-left-style: solid;">
		
		<center>
		<div id="imagens">
		</div>
		</center>
		
		</td>
		<td>
			ID da rede:</td><td> <input style="background: #ffc;" type="text" name="ID_Usuario" value="<?= $ID_Usuario?>" readonly="true">
		</td>
		<td>
		
		</td>
	</tr>

	
	<tr>
		<td>
			Nome:</td><td> <input type="text" name="nome" required="required" value="<?= $nomefr ?>" size="19"> <input type="text" name="sobrenome" required="required" value="<?= $sobrenomefr ?>" size="43">
		</td>
		<td>
		* Coloque seu nome completo.
		</td>
	</tr>
	<tr>
		<td>
			<p>Cargo: </td><td><input type="text" required="required" name="cargo" value="<?= $bd_cargo ?>" size="67">
			
			<!-- <select name="cargo" required="required">
			<option value="<?= $bd_cargo ?>"><?= $bd_cargo ?></option>
			<option value="Assistente Administrativo de Gestão">Assistente Administrativo de Gestão</option>
			</select> -->


		</td>
		<td>
		
		</td>
	</tr>
	<tr>
		<td>
		<p>Unidade: </td><td>					
		<select name="departamento" required="required">
			<option value=""></option>
			<option value="GABINETE">GABINETE</option>
			<option value="ASCOM">ASCOM</option>
			<option value="ATAJ">ATAJ</option>
			<option value="ATECC">ATECC</option>
			<option value="ATIC">ATIC</option>
			<option value="CAF">CAF</option>
			<option value="CAF / DGP">CAF / DGP</option>
			<option value="CAF / DLC">CAF / DLC</option>
			<option value="CAF / DOF">CAF / DOF</option>
			<option value="CAF / DSUP">CAF / DSUP</option>
			<option value="CAP">CAP</option>
			<option value="CAP / ARTHUR SABOYA">CAP / ARTHUR SABOYA</option>
			<option value="CAP / DEPROT">CAP / DEPROT</option>
			<option value="CAP / DPCI">CAP / DPCI</option>
			<option value="CAP / DPD">CAP / DPD</option>
			<option value="CAP / NÚCLEO DE ATENDIMENTO">CAP / NÚCLEO DE ATENDIMENTO</option>
			<option value="CASE">CASE</option>
			<option value="CASE / DCAD">CASE / DCAD</option>
			<option value="CASE / DDU">CASE / DDU</option>
			<option value="CASE / DLE">CASE / DLE</option>
			<option value="CASE / STEL">CASE / STEL</option>
			<option value="CEPEUC">CEPEUC</option>
			<option value="CGPATRI">CGPATRI</option>
			<option value="COMIN">COMIN</option>
			<option value="COMIN / DCIGP">COMIN / DCIGP</option>
			<option value="COMIN / DCIMP">COMIN / DCIMP</option>
			<option value="CONTRU">CONTRU</option>
			<option value="CONTRU / DACESS">CONTRU / DACESS</option>
			<option value="CONTRU / DINS">CONTRU / DINS</option>
			<option value="CONTRU / DLR">CONTRU / DLR</option>
			<option value="CONTRU / DSUS">CONTRU / DSUS</option>
			<option value="DEUSO">DEUSO</option>
			<option value="GEOINFO">GEOINFO</option>
			<option value="GTEC">GTEC</option>
			<option value="ILUME">ILUME</option>
			<option value="PARHIS">PARHIS</option>
			<option value="PARHIS / DHIS">PARHIS / DHIS</option>
			<option value="PARHIS / DHMP">PARHIS / DHMP</option>
			<option value="PARHIS / DPS">PARHIS / DPS</option>
			<option value="PLANURB">PLANURB</option>
			<option value="PLANURB">PLANURB / DOT</option>
			<option value="PLANURB">PLANURB / DMA</option>
			<option value="PLANURB">PLANURB / DART</option>
			<option value="RESID">RESID</option>
			<option value="RESID / DRGP">RESID / DRGP</option>
			<option value="RESID / DRPM">RESID / DRPM</option>
			<option value="RESID / DRU">RESID / DRU</option>
			<option value="SERVIN">SERVIN</option>
			<option value="SERVIN / DSIGP">SERVIN / DSIGP</option>
			<option value="SERVIN / DSIMP">SERVIN / DSIMP</option>
		</select>


		</td>
		<td>
		
		</td>
	</tr>
	<tr>
		<td>
				<p>E-mail: </td><td><input style="background: #ffc;" type="text" value="<?= $emailfr ?>" name="email" readonly="true" size="67">
		</td>
		<td>
		
		</td>
	</tr>
	<tr>
		<td>
				<p>Telefone: +55 (11) </td><td><input type="text" id="tele1" name="t1" onkeypress="formatar_mascara(this,'####-####')" value="<?=$bd_tel?>" size="9"> * Apenas números.
		</td>
		<td>

		</td>
	</tr>
		<tr>
		<td>
		<p>Endereço: </td><td><textarea name="endereco" rows="2" cols="51">Rua São Bento, 405 - 22º andar
CEP: 01011-100 - São Paulo - S.P.</textarea>
		</td>
		<td>
		
		</td>
	</tr>
	<tr>
			<td>
				<p>Site: </td><td><input type="text" id="site" name="site" size="67" value="http://smul.prefeitura.sp.gov.br/">
		</td>
		<td>
		
		</td>
	</tr>
			<tr>
		<td>
				<p>Data de nascimento: </td><td><input type="text" id="nascdia" name="nascdia" maxlength="2" size="2" Value="<?=$bd_dia?>">/<input type="text" id="nascmes" name="nascmes" maxlength="2" size="2" Value="<?=$bd_mes?>"> * Dia / Mês
		</td>
		<td>
		
		</td>
	</tr>
	<tr>
		<td>
				</td><td><input type="submit" name="gerar" value="Criar" onclick="assina()"> <input type="reset" value="Limpar">
		</td>
	</tr>
</form>



<?php endif;?>
