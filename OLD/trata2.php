<?php

$ID_Usuario=mb_strtolower($_REQUEST['usuario'],'UTF-8');

$user = $_REQUEST['usuario']."@rede.sp";

$psw = $_REQUEST['senha'];

$inicial = mb_strtolower($_REQUEST['usuario'],'UTF-8');


echo $psw;

