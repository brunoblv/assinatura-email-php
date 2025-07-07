<?php
  include "incluebd.php";
  
  // Tipo de img
  header('Content-type: image/jpg');

	$logo = $_POST['secretaria'];
	$usr = $_POST['ID_Usuario'];

	
  // Pega img de fundo

  if ($logo == "SEL") {
	  $secretaria = $_POST['secretaria'];
		$jpg_image = imagecreatefrompng('img/SEL/fundo.png');
  }
  if ($logo == "SMDU"){
	  	  $secretaria = $_POST['secretaria'];
		$jpg_image = imagecreatefrompng('img/SMDU/fundo.png');
  }
  if ($logo == "SMADS"){
	  	  $secretaria = $_POST['secretaria'];
		$jpg_image = imagecreatefrompng('img/SMADS/fundo.png');
  }    
  if ($logo == "SMUL"){
    $secretaria = $_POST['secretaria'];
    $jpg_image = imagecreatefrompng('img/SMUL/fundo.png');
  }


  // Cores
  $preto = imagecolorallocate($jpg_image, 0, 0, 0);
  $preto80 = imagecolorallocate($jpg_image, 20, 20, 20);
  $azul = imagecolorallocate($jpg_image, 10, 50, 153);

  // fontes
  $font_path = '/var/www/html/ass/fontes/Arial.ttf';
  $font_path1 = '/var/www/html/ass/fontes/Arial_Bold.ttf';
  
  

  $L1 = mb_strtoupper($_POST['nome']);
  // $L2 = $_POST['cargo'];
  $L21 =  mb_strtoupper($_POST['cargo'])." / " . mb_strtoupper($_POST['departamento']);
  $L4 = $_POST['email'];
  $L3 = "Tel.: 55 11 " . $_POST['t1'];
  // $L5 = $_POST['endereco']; 
  $L5 = $_POST['endereco'];
  $L51 = $_POST['cep'];
  $L6 = $_POST['site'];
  // $L7 = "Siga a @smul_sp nas redes sociais!";
  // $L8 = "Facebook | Instagram | Twitter";

  //$L8 = " <a href='https://www.facebook.com/smulsp' target='FB'>Facebook</a> | <a href='https://www.instagram.com/smul_sp/' target='Inatagram'>Instagram</a> | <a href='https://twitter.com/smul_sp' target='Twitter'>Twitter</a>";
  $diretorioFoto = 'ass/' . str_replace(' ','_',$L1) . '.jpg';
   
  // imprime a imagem
  imagettftext($jpg_image, 14, 0, 200, 46, $preto, $font_path1, $L1);
  imagettftext($jpg_image, 10, 0, 200, 64, $preto80, $font_path, $L21);
  imagettftext($jpg_image, 10, 0, 200, 83, $preto80, $font_path, $L4);
  imagettftext($jpg_image, 10, 0, 200, 98, $preto80, $font_path, $L3);
  imagettftext($jpg_image, 10, 0, 200, 113, $preto80, $font_path, $L5);
  imagettftext($jpg_image, 10, 0, 200, 128, $preto80, $font_path, $L51);
  imagettftext($jpg_image, 10, 0, 200, 143, $preto80, $font_path, $L6);
  imagefilledrectangle($jpg_image, 180,0,182,180, $preto);

  // salva
  imagejpeg($jpg_image, $diretorioFoto, 110);

  // limpa a memoria
  imagedestroy($jpg_image);
  //readfile($diretorioFoto);
  
  header("Location: ass.php?n=$diretorioFoto&usr=$usr");
?>