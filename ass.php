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
		<style>

@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Poppins:wght@300;400;500;600;700&display=swap');

body{
color: #000;
font-family: 'Open Sans', sans-serif;
font-size: 14px;
font-style: normal;
font-weight: 400;
line-height: normal;        
}
.olho {
	cursor: pointer;
	filter: grayscale(1);
}
.olho:hover {
	filter: grayscale(0.3);
}
.titulo_1{
	color: #395AAD;
	font-family: 'Open Sans', sans-serif;
	font-size: 20px;
}
.titulo_2{
	color: #000;
	font-family: 'Open Sans', sans-serif;
	font-size: 16px;
	font-style: bold;
	font-weight: 700;
	line-height: normal;
	margin: 1rem;
        }
.titulo_2 h2{
	width: 650px;
	font-size: 16px;
	font-style: bold;
	font-weight: 700;
	text-align: center;
	margin: auto;
        }
.formulario{
	display: flex;
	flex-flow: column nowrap;
	text-align: left;
	margin: auto;
}
.formulario_ass{
    display: grid;
	width: 850px;
    grid-template-columns: 1.7fr 1fr 2fr;
	grid-gap: 3px;
	margin: 30px auto;
	height: 800px;
}
.formulario_ass{
    display: grid;
	width: 850px;
    grid-template-columns: 1.7fr 1fr 1fr;
	grid-gap: 3px;
	margin: 30px auto;
	height: 800px;
}
.campo_1{
	width: max-content;
	flex: 1 1 auto;
	margin: 5px 0;
	margin: 10px;
	color: #666;
	font-weight: 700;
}
.campo_1 .campo_inserir{
	width: 250px;
	margin: 1px auto;
	align-self: right;
}
.campo_ass{
	width: auto;
	margin-right: 2%;
	align-self: center;
	text-align: right;
	color: #666;
	font-weight: 700;
}
.campo_ass_imagem{
	grid-row: span 15;
	width: 200px;
}
.campo_ass_botoes{
	grid-column: span 3;
	margin: auto;
}
.botao_inserir{
	width: 115px;
	margin:15px auto;
	align-self: center;
}
input.botao_inserir {
	height: 46px;
	border-radius: 5px;
	border: 2px solid #E3E3E3;
	background: #F5F5F5;
	flex-shrink: 1;
	color: #666;
	font-size: 14px;
	font-style: normal;
	font-weight: 700;
	line-height: normal;
	cursor: pointer;
	transition: all 0.3s;
}
input.botao_inserir:hover{
	background: #F0F0F0;
}
.campo_inserir{
	width: 450px;
	margin: 1px auto;
	align-self: right;
}
.campo_menor_inserir{
	width: 60px;
}
input.campo_inserir,
input.campo_menor_inserir,
select.campo_inserir,
select.campo_menor_inserir{
	height: 46px;
	border-radius: 5px;
	border: 2px solid #E3E3E3;
	background: #FFF;
	flex-shrink: 1;
	color: #666;
	font-size: 14px;
	font-style: normal;
	text-align: center;
	font-weight: 700;
	line-height: normal; 
}
/* 

.campo_ass:nth-child(-n + 26) {
  border: 2px solid orange;
  margin-bottom: 1px;
} */
.campo_ass:nth-child(27) {
  width: auto;
  text-align: left;
  font-size: 1.2rem;
  vertical-align: center;
}


		</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php header("Content-type: text/html; charset=utf-8");

if(empty($_REQUEST)) 
	header("Location: index.php");


include "config.php";



if(isset($_GET['n'])):

$inicial = $_REQUEST['usr'];


$busca = mysqli_query($mysqli, "select * from tbl_telefones where cp_usuario_rede='$inicial'") or trigger_error('Erro ao executar consutla. Detalhes = ' . mysqli_error($mysqli));

if(mysqli_num_rows($busca)>0) {
	while ($dados = mysqli_fetch_array($busca)) {
	$bd_nome = $dados['cp_nome'];
	$bd_secretaria = $dados['cp_secretaria'];
	$bd_tel = $dados['cp_telefone'];
	$bd_cargo = $dados['cp_cargo'];
	$bd_departamento = $dados['cp_departamento'];  // ***************LIBERAR DEPOIS DE TUDO PADRONIZADO***************
	$bd_andar = $dados['cp_andar'];
	$bd_cep = $dados['cp_cep'];
	$bd_email = $dados['cp_email'];
	$bd_site = $dados['cp_site'];

	}
	echo '

<font face="Arial">
		<div class="titulo_2">
			<h2>2º Por favor confira as informações e copie a assinatura em HTML abaixo selecionando, copiando e colando no seu Outlook.</h2>
		</div>
<br>
<br>
<table align="center">
<tr>
	<td width="150px">
    		&nbsp; &nbsp; &nbsp; &nbsp; <img src=img/'.$bd_secretaria.'/ass.png width=130px > &nbsp; &nbsp; &nbsp; &nbsp;
		
	<td width=1px bgcolor="#000000"></td>
			
	<td style="padding-left: 10px;" width=350px>
			<span style="font-size: 14pt"><b>'.mb_strtoupper($bd_nome).'</b><br></span>
			<span style="font-size: 9pt">'.mb_strtoupper($bd_cargo).' / '.mb_strtoupper($bd_departamento).'<br></span>
			<span style="font-size: 9pt">
			<br>
			<a href=mailto:'.$bd_email.' style="color: black; text-decoration:none">'.$bd_email.'</a>
			<br>
			Tel.: 55 11 '.$bd_tel.'	
			<br>
			<font face=Arial>'.$bd_andar.' 
			<br>
			<font face=Arial>'.$bd_cep.' 
			<br>

			<a href="https://www.capital.sp.gov.br/" style="color: black; text-decoration:none">www.prefeitura.sp.gov.br</a><br>
			</span>

	<span style="background-color: rgb(255, 255, 255); display: inline !important; color: rgb(10, 50, 153);">

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
	$bd_cep = "";
  	$bd_email = "";
	$bd_dia = "";
	$bd_mes = "";
}



mysqli_close($mysqli);


$img = urldecode( $_GET['n'] );
echo '
<html>
<head>
</head>
<body>
<font face="Arial">

<center>
<div class="titulo_2">Ou clique na imagem para iniciar o download:</div>
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
 $nomefr = $data[$i]["givenname"][0] . " " . $data[$i]["sn"][0];
 $emailfr = mb_strtolower($data[$i]["mail"][0]);
}


$busca = mysqli_query($mysqli, "select * from tbl_telefones where cp_usuario_rede='$inicial'") or trigger_error('Erro ao executar consulta. Detalhes = ' . mysqli_error($mysqli));

if(mysqli_num_rows($busca)>0) {
	while ($dados = mysqli_fetch_array($busca)) {
	$bd_tel = $dados['cp_telefone'];
	$bd_cargo = $dados['cp_cargo'];
	$bd_departamento = $dados['cp_departamento'];  // ***************LIBERAR DEPOIS DE TUDO PADRONIZADO***************
  	$bd_andar = $dados['cp_andar'];
	$bd_cep = $dados['cp_cep'];
  	$bd_email = $dados['cp_email'];
	$bd_dia = $dados['cp_nasc_dia'];
	$bd_mes = $dados['cp_nasc_mes'];
	}
}else{
	$bd_tel = "";
	$bd_cargo = "";
	$bd_departamento = "";
  	$bd_andar = "";
	$bd_cep = "";
  	$bd_email = "";
	$bd_dia = "";
	$bd_mes = "";
}


mysqli_close($mysqli);


?>


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
		
		if((nome==null||nome=="")||(cargo==null||cargo=="")||(departamento==null||departamento=="")||(email==null||email=="")||(nascdia==null||nascdia=="")||(nascmes==null||nascmes=="")){
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
		/* display: none; */
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

	td span #nome_assinatura{
		font-size:140px;
		font-weight: bold;
	}



	  </style>
	
<script>
       function mudaimagem(item) {
               var img = document.getElementById('imagens');
               img.innerHTML = '<img src="img/' + item + '/logo.png" width=200px >';

			   document.getElementById('site').value='https://'+'www.capital.sp.gov.br';
		
       }
</script>


</head>
<body>

<!--  -->



<div class="titulo_2"><h2>1º Para criar a assinatura de e-mail, favor preencher os itens abaixo:</h2>
</div>

<form name="ass" action="./gera_img.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8" class="formulario_ass">


		<div class="campo_ass">
			Secretaria:
		</div>
		<div class="campo_ass"><select id="secretaria" name="secretaria" onChange="mudaimagem(this.value);" required="required" class="campo_inserir">
		<option value=""></option>
		<option value="SMUL">SMUL - Secretaria Municipal de Urbanismo e Licenciamento</option>
		<!--<option value="PSUrb">SP Urbanismo</option>-->
		<!--<option value="SMADS">SMADS - Secretaria Municipal de Assistência e Desenvolvimento Social </option>-->
		</select>
		</div>

		<!-- Terceira Coluna com imagem do logo da prefeitura -->
		<div class="campo_ass_imagem" id="imagens">
		</div>


		<div class="campo_ass">
			ID da rede: 
		</div>
		<div class="campo_ass"><input style="background: #ffc;" type="text" name="ID_Usuario" value="<?= $ID_Usuario?>" readonly="true" class="campo_inserir">
		</div>

		<div class="campo_ass">
			Nome:
		</div>
		<div class="campo_ass"><input type="text" name="nome" required="required" value="<?= $nomefr ?>" size="19" class="campo_inserir">
		</div>


		<div></div>
		<div>* Coloque seu nome completo.</div>

		<div class="campo_ass">
		Cargo: 
		</div>					
		<div class="campo_ass"><input type="text" required="required" name="cargo" value="<?= $bd_cargo ?>" size="67" class="campo_inserir">
		<!-- <select name="cargo" required="required" class="campo_inserir">
		<option value="<?= $bd_cargo ?>"><?= $bd_cargo ?></option>
		<option value="Assistente Administrativo de Gestão">Assistente Administrativo de Gestão</option>
		</select> -->
		</div>

		<div class="campo_ass">
			Unidade:
		</div>
		<div class="campo_ass">
		<select name="departamento" required="required" class="campo_inserir">
		<option value=""></option>
			<option value="GABINETE">GABINETE</option>
			<option value="ASCOM">ASCOM</option>
			<option value="ATAJ">ATAJ</option>
			<option value="ATECC">ATECC</option>
			<option value="ATIC">ATIC</option>
			<option value="CAEPP">CAEPP</option>
			<option value="CAEPP / DECPP">CAEPP / DECPP</option>
			<option value="CAEPP / DERPP">CAEPP / DERPP</option>
			<option value="CAEPP / DESPP">CAEPP / DESPP</option>
			<option value="CAF">CAF</option>
			<option value="CAF / DGP">CAF / DGP</option>
			<option value="CAF / DLC">CAF / DLC</option>
			<option value="CAF / DOF">CAF / DOF</option>
			<option value="CAF / DRV">CAF / DRV</option>
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
			<option value="CEPEUC">CEPEUC</option>
			<option value="CEPEUC / DCIT">CEPEUC / DCIT</option>
			<option value="CEPEUC / DDOC">CEPEUC / DDOC</option>
			<option value="CEPEUC / DVF">CEPEUC / DVF</option>
			<option value="COMIN">COMIN</option>
			<option value="COMIN / DCIGP">COMIN / DCIGP</option>
			<option value="COMIN / DCIMP">COMIN / DCIMP</option>
			<option value="CONTRU">CONTRU</option>
			<option value="CONTRU / DACESS">CONTRU / DACESS</option>
			<option value="CONTRU / DINS">CONTRU / DINS</option>
			<option value="CONTRU / DLR">CONTRU / DLR</option>
			<option value="CONTRU / DSUS">CONTRU / DSUS</option>
			<option value="DEUSO">DEUSO</option>
			<option value="DEUSO / DMUS">DEUSO / DMUS</option>
			<option value="DEUSO / DNUS">DEUSO / DNUS</option>
			<option value="DEUSO / DSIZ">DEUSO / DSIZ</option>
			<option value="GEOINFO">GEOINFO</option>
			<option value="GTEC">GTEC</option>
			<option value="ILUME">ILUME</option>
			<option value="PARHIS">PARHIS</option>
			<option value="PARHIS / DHGP">PARHIS / DHGP</option>
			<option value="PARHIS / DHMP">PARHIS / DHMP</option>
			<option value="PARHIS / DHPP">PARHIS / DHPP</option>
			<option value="PARHIS / DPS">PARHIS / DPS</option>
			<option value="PLANURB">PLANURB</option>
			<option value="PLANURB / DART">PLANURB / DART</option>
			<option value="PLANURB / DMA">PLANURB / DMA</option>
			<option value="PLANURB / DOT">PLANURB / DOT</option>
			<option value="RESID">RESID</option>
			<option value="RESID / DRGP">RESID / DRGP</option>
			<option value="RESID / DRH">RESID / DRH</option>
			<option value="RESID / DRVE">RESID / DRVE</option>
			<option value="SERVIN">SERVIN</option>
			<option value="SERVIN / DSIGP">SERVIN / DSIGP</option>
			<option value="SERVIN / DSIMP">SERVIN / DSIMP</option>
			<option value="STEL">STEL</option>
		</select>
		</div>

		<div class="campo_ass">E-mail: 
		</div>
		<div class="campo_ass">
		<input style="background: #ffc;" type="text" value="<?= $emailfr ?>" name="email" readonly="true" size="67" class="campo_inserir">
		</div>


		<div class="campo_ass">Telefone: 55 11
		</div>
		<div class="campo_ass"><input type="tel" pattern="[0-9]{4}.[0-9]{4}" maxlength="9" id="tele1" name="t1" onkeypress="formatar_mascara(this,'####.####')" value="<?=$bd_tel?>" size="9" class="campo_inserir">
		</div>

		<div></div>
		<div>* Preencher apenas com números</div>

		<div class="campo_ass">Endereço:
		</div>
		<div class="campo_ass"><input type="text" name="endereco" rows="1" cols="60" class="campo_inserir" value="Rua São Bento, 405 | 22º andar">
		</div>


		<div class="campo_ass">CEP: 
		</div>	
		<div class="campo_ass"><input style="background: #ffc;" type="text" name="cep" readonly="true" rows="1" cols="60" class="campo_inserir" value="01011 100 | São Paulo | SP">
		</div>


		<div class="campo_ass">Site: 
		</div>
		<div class="campo_ass"><input style="background: #ffc;" type="text" name="site" readonly="true" size="67" value="www.prefeitura.sp.gov.br" class="campo_inserir">
		</div>


		<div class="campo_ass">Data de nascimento: 
		</div>
		<div class="campo_ass"><input type="tel" id="nascdia" placeholder="--" min="0" max="31"  required="required" name="nascdia" maxlength="2" size="2" Value="<?=$bd_dia?>" class="campo_menor_inserir"> / <input type="tel" placeholder="--" min="0" max="12" pattern="[0-1]{1}[0-9]{1}" id="nascmes" name="nascmes" required="required" maxlength="2" size="2" Value="<?=$bd_mes?>" class="campo_menor_inserir">
		</div>

		<div></div>
		<div>* Dia / Mês (Caso não queira preencher, coloque o número 00 nos dois campos)
		</div>

		
<div class="campo_ass_botoes">
	<input type="submit" name="gerar" value="Criar" onclick="assina()" class="botao_inserir">
	<input type="reset" value="Limpar" class="botao_inserir">
</div>

</form>

<?php endif;?>
