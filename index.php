<html>

<head>


	<style>
		@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Poppins:wght@300;400;500;600;700&display=swap');

		body {
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

		.titulo_1 {
			color: #395AAD;
			font-family: 'Open Sans', sans-serif;
			font-size: 20px;
		}

		.titulo_2 {
			color: #000;
			font-family: 'Open Sans', sans-serif;
			font-size: 16px;
			font-style: bold;
			font-weight: 700;
			line-height: normal;
			margin: 1rem;
		}

		.titulo_2 h2 {
			width: 650px;
			font-size: 16px;
			font-style: bold;
			font-weight: 700;
			text-align: center;
			margin: auto;
		}

		.formulario {
			display: flex;
			flex-flow: column nowrap;
			text-align: left;
			margin: auto;
		}

		.formulario_ass {
			display: grid;
			width: 850px;
			grid-template-columns: 1.7fr 1fr 2fr;
			grid-gap: 3px;
			margin: 30px auto;
			height: 800px;
		}

		.formulario_ass {
			display: grid;
			width: 850px;
			grid-template-columns: 1.7fr 1fr 1fr;
			grid-gap: 3px;
			margin: 30px auto;
			height: 800px;
		}

		.campo_1 {
			width: max-content;
			flex: 1 1 auto;
			margin: 5px 0;
			margin: 10px;
			color: #666;
			font-weight: 700;
		}

		.campo_1 .campo_inserir {
			width: 250px;
			margin: 1px auto;
			align-self: right;
		}

		.campo_ass {
			width: auto;
			margin-right: 2%;
			align-self: center;
			text-align: right;
			color: #666;
			font-weight: 700;
		}

		.campo_ass_imagem {
			grid-row: span 15;
			width: 200px;
		}

		.campo_ass_botoes {
			grid-column: span 3;
			margin: auto;
		}

		.botao_inserir {
			width: 115px;
			margin: 15px auto;
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
		}

		input.botao_inserir:hover {
			background: #F0F0F0;
		}

		input.carregar_btn:hover {
			background: #F0F0F0;
		}

		.campo_inserir {
			width: 450px;
			margin: 1px auto;
			align-self: right;
		}

		.campo_menor_inserir {
			width: 60px;
		}

		input.campo_inserir,
		input.campo_menor_inserir,
		input.carregar_btn,
		select.campo_inserir,
		select.campo_menor_inserir {
			height: 46px;
			border-radius: 5px;
			border: 2px solid #E3E3E3;
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

		.carregar_btn {
			width: 115px;
			margin: 15px auto;
			align-self: center;
			cursor: pointer;
			background: #F5F5F5;
			transition: all 0.3s;
		}

		.anima_carregando {
			pointer-events: none;
			width: 30px;
			height: 30px;
			margin: 25px auto;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #395AAD;
			animation: an1 1s ease infinite;
			transition: all 0.6s;
		}

		@keyframes an1 {
			0% {
				transform: rotate(0turn);
			}

			100% {
				transform: rotate(1turn);
			}

		}
	</style>

</head>

<body>



	<?php
	if (empty($_REQUEST)) {
		$erro = "";
	} else {
		$erro = $_GET['m'];
	}

	if ($erro == "erro") {
		echo "<center><H2><font color=red>Erro no login, favor testar novamente.</font></h2></center><br>";
	} else {
		echo "<div class='titulo_2'><h2>Digite seu usuário e senha da rede.</h2></div>";
	}

	?>

	<form method="post" action="ass.php" name="form" AUTOCOMPLETE='ON' onSubmit="return valida()" class="formulario">

		<div class="formulario" id="container_formulario">
			<div class="campo_1">
				Usuário de rede:
				<input type="text" name="usuario" maxlength="7" class="campo_inserir">
			</div>
			<div class="campo_1">

				Senha de rede:&nbsp;&nbsp;
				<input type="password" name="senha" id="pass" class="campo_inserir" maxlength="30"> <img
					src="img/olho.png" id="olho" class="olho" alt="Clique para visualizar a senha.">
				<div class="botao_inserir"><input type="submit" value="Entrar" class="carregar_btn"></div>
			</div>
	</form>

	<br>






	<script language="JavaScript" type="text/javascript" src="funcs.js"></script>

	<script type="text/javascript">
		document.getElementById('olho').addEventListener('mousedown', function () {
			document.getElementById('pass').type = 'text';
		});

		document.getElementById('olho').addEventListener('mouseup', function () {
			document.getElementById('pass').type = 'password';
		});

		// Para que o password não fique exposto apos mover a imagem.
		document.getElementById('olho').addEventListener('mousemove', function () {
			document.getElementById('pass').type = 'password';
		});


		function mudaimagem(item) {
			var img = document.getElementById('imagens');
			img.innerHTML = '<img src="img/' + item + '/logo.png" width=200px >';

			//    document.getElementById('site').value='https://'+'www.capital.sp.gov.br';
		}
	</script>

</body>

</html>