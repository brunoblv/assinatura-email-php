<?php
  include "config.php";
  
  
  $inicial= $_REQUEST['ID_Usuario'];
  $Lsecretaria = $_POST['secretaria'];
  $Lnome = $_POST['nome'] . " " . $_POST['sobrenome'];
  $Lcargo = $_POST['cargo'];
  $Ldepartamento = $_POST['departamento'];
  $Ltelefone = $_POST['t1'];
  $Lendereco = $_POST['endereco'];
  $Lsite = $_POST['site'];
  $Lemail = $_POST['email'];
  $Lnascdia = str_pad($_POST['nascdia'], 2, 0, STR_PAD_LEFT);
  $Lnascmes = str_pad($_POST['nascmes'], 2, 0, STR_PAD_LEFT);

echo $inicial;
$busca = mysql_query("select * from tbl_telefones where cp_usuario_rede='$inicial'"); // or trigger_error('Erro ao executar consutla. Detalhes = ' . mysql_error());


if(mysql_num_rows($busca)>0) {
	$sql = ("UPDATE tbl_telefones SET cp_nome='$Lnome',cp_secretaria='$Lsecretaria',cp_cargo='$Lcargo',cp_departamento='$Ldepartamento',cp_telefone='$Ltelefone',cp_andar='$Lendereco',cp_email='$Lemail',cp_site='$Lsite',cp_nasc_dia='$Lnascdia',cp_nasc_mes='$Lnascmes' where cp_usuario_rede='$inicial'");
	$resultado = mysql_query($sql)or die (mysql_error());
	echo $resultado;
}else{
	$sql = "INSERT INTO tbl_telefones(cp_usuario_rede,cp_secretaria,cp_nome,cp_cargo,cp_departamento,cp_telefone,cp_andar,cp_email,cp_site,cp_nasc_dia,cp_nasc_mes) VALUES ('$inicial','$Lsecretaria','$Lnome','$Lcargo','$Ldepartamento','$Ltelefone','$Lendereco','$Lemail','$Lsite','$Lnascdia','$Lnascmes')";

	$query = mysql_query($sql);

	if ($query == true) {
		echo "Incerido com sucessso";
	}else{
		echo "Erro: ".mysql_error();
	}
	
}
mysql_close($db);