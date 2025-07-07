<?php
  include "incluebd.php";
  
   //Tipo de img
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
  $preto80 = imagecolorallocate($jpg_image, 88, 88, 90);
  $azul = imagecolorallocate($jpg_image, 10, 50, 153);

  // fontes
  $font_path = '/var/www/html/ass/fontes/Calibri.ttf';
  $font_path1 = '/var/www/html/ass/fontes/Calibri.ttf';
  


  $L1 = $_POST['nome'] . " " . $_POST['sobrenome'];
  $L2 = $_POST['cargo'];
  $L21 =  $secretaria." - " . $_POST['departamento'];
  $L3 = "+ 55 (11) " . $_POST['t1'];
  $L4 = $_POST['email'];
  $L5 = $_POST['endereco']; 
  //$L51 = "CEP. 01011-100 - São Paulo - S.P.";
  $L6 = $_POST['site']; ;
  $L7 = "Siga a @smul_sp nas redes sociais!";
  $L8 = "Facebook | Instagram | Twitter";

  //$L8 = " <a href='https://www.facebook.com/smulsp' target='FB'>Facebook</a> | <a href='https://www.instagram.com/smul_sp/' target='Inatagram'>Instagram</a> | <a href='https://twitter.com/smul_sp' target='Twitter'>Twitter</a>";
  $diretorioFoto = 'ass/' . str_replace(' ','_',$L1) . '.jpg';
   
  // imprime a imagem
  imagettftext($jpg_image, 12, 0, 190, 15, $preto, $font_path1, $L1);
  imagettftext($jpg_image, 10, 0, 190, 28, $preto80, $font_path, $L2);
  imagettftext($jpg_image, 10, 0, 190, 41, $preto80, $font_path, $L21);

  imagettftext($jpg_image, 10, 0, 190, 54, $preto80, $font_path, $L3);
  imagettftext($jpg_image, 10, 0, 190, 67, $preto80, $font_path, $L4);

  imagettftext($jpg_image, 10, 0, 190, 93, $preto80, $font_path, $L5);

  //imagettftext($jpg_image, 10, 0, 190, 121, $preto80, $font_path, $L51);
  imagettftext($jpg_image, 10, 0, 190, 119, $preto80, $font_path, $L6);
  imagettftext($jpg_image, 10, 0, 190, 132, $azul, $font_path, $L7);
  imagettftext($jpg_image, 10, 0, 190, 145, $azul, $font_path, $L8);
  imagefilledrectangle($jpg_image, 180,0,182,180, $preto);

  // salva
  imagejpeg($jpg_image, $diretorioFoto, 110);

  // limpa a memoria
  imagedestroy($jpg_image);
  //readfile($diretorioFoto);
  
  header("Location: ass.php?n=$diretorioFoto&usr=$usr");
?>

