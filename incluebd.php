<?php
  include "config.php";
  
  
  $inicial= $_REQUEST['ID_Usuario'];
  $Lsecretaria = $_POST['secretaria'];
  $Lnome = $_POST['nome'];
  $Lcargo = $_POST['cargo'];
  $Ldepartamento = $_POST['departamento'];
  $Ltelefone = $_POST['t1'];
  $Lendereco = $_POST['endereco'];
  $Lcep = $_POST['cep'];
  $Lsite = $_POST['site'];
  $Lemail = $_POST['email'];
  $Lnascdia = str_pad($_POST['nascdia'], 2, 0, STR_PAD_LEFT);
  $Lnascmes = str_pad($_POST['nascmes'], 2, 0, STR_PAD_LEFT);

echo $inicial;
$busca = mysqli_query($mysqli, "select * from tbl_telefones where cp_usuario_rede='$inicial'"); // or trigger_error('Erro ao executar consutla. Detalhes = ' . mysqli_error());


if(mysqli_num_rows($busca)>0) {
	$sql = ("UPDATE tbl_telefones SET cp_nome='$Lnome',cp_secretaria='$Lsecretaria',cp_cargo='$Lcargo',cp_departamento='$Ldepartamento',cp_telefone='$Ltelefone',cp_andar='$Lendereco',cp_cep='$Lcep',cp_email='$Lemail',cp_site='$Lsite',cp_nasc_dia='$Lnascdia',cp_nasc_mes='$Lnascmes' where cp_usuario_rede='$inicial'");
	$resultado = mysqli_query($mysqli, $sql)or die (mysqli_error($mysqli));
	echo $resultado;
}else{
	$sql = "INSERT INTO tbl_telefones(cp_usuario_rede,cp_secretaria,cp_nome,cp_cargo,cp_departamento,cp_telefone,cp_andar,cp_cep,cp_email,cp_site,cp_nasc_dia,cp_nasc_mes) VALUES ('$inicial','$Lsecretaria','$Lnome','$Lcargo','$Ldepartamento','$Ltelefone','$Lendereco','$Lcep','$Lemail','$Lsite','$Lnascdia','$Lnascmes')";

	$query = mysqli_query($mysqli, $sql);

	if ($query == true) {
		echo "Inserido com sucessso";
	}else{
		echo "Erro: ".mysqli_error($mysqli);
	}
	
}
mysqli_close($mysqli);