
<html>
<head>


<style>
        #pass {
  width: 150px;
  padding-right: 20px;
}

.olho {
  cursor: pointer;

}
    </style>

</head>
<body>






<?php
if(empty($_REQUEST)) {
	$erro = "";
	}else{
	$erro = $_GET['m'];
	}

if ($erro == "erro") { echo "<center><H2><font color=red>Erro no login, favor testar novamente.</font></h2></center><br>";  }else{ echo "<center><H2><font color=green>Digite seu usuário e senha da rede.</font></h2></center><br>"; }

?>

    <form method="post" action="ass.php" name="form" AUTOCOMPLETE='ON' onSubmit="return valida()">
	<center>
        Usuário de rede:
		<input type="text" name="usuario" size="8" maxlength="7" >
        <br> <br>
        Senha de rede:
		<input type="password" name="senha" id="pass" size="50" maxlength="30" > <img src="img/olho.png" id="olho" class="olho" alt="Clique para visualizar a senha.">
        <br><br>
	
        <input type="submit" value="Entrar">
    </form>

	
	
	<script language="JavaScript" type="text/javascript" src="funcs.js"></script>

<script type="text/javascript">
  document.getElementById('olho').addEventListener('mousedown', function() {
  document.getElementById('pass').type = 'text';
});

document.getElementById('olho').addEventListener('mouseup', function() {
  document.getElementById('pass').type = 'password';
});

// Para que o password não fique exposto apos mover a imagem.
document.getElementById('olho').addEventListener('mousemove', function() {
  document.getElementById('pass').type = 'password';
});
    </script>

</body>
</html>