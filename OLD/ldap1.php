<?php

 // Servidor Active Directory
 $phpAD["ldap_server"] = "ldap://10.10.65.242";

 // Usuario e senha necessário dominio
 $phpAD["auth_user"] = "rede\d827520";
 $phpAD["auth_pass"] = "AveMaria-01";

 // Unidade organizacional
 //OU=Unidade organizacional
//DC=Controlador de Domínio
$phpAD["ldap_dn"] = " DC=rede, DC=sp";

 // OU padrão
 $phpAD["ldap_default_ou"] = "SMDU";

 // Dominio Active directory
 $phpAD["ad_domain_name"] = "rede";



 set_time_limit(0);

 // Base do dominio para procura.
  $base_dn = $phpAD["ldap_dn"];

 // Conectando ao servidor
 if (!($connect=@ldap_connect($phpAD["ldap_server"]))){
  echo "Could not connect to ldap server";
  }
 // Autenticando
 if (!($bind=@ldap_bind($connect, $phpAD["auth_user"], $phpAD["auth_pass"]))){
  echo "Unable to bind to server";
 }
  $filtro = "(&(objectClass=user)(objectCategory=person)(displayname=*))";

 $mostrar = array("displayname","samaccountname","useraccountcontrol","userprincipalname","distinguishedname","proxyaddresses");

 // Busca no active directory $busca = ldap_search($ds, $ldap_dn, $filtro/*, $attributes*/);
 if (!($busca=@ldap_search($connect, $base_dn, $filtro, $mostrar)))
  die("Não foi possível realizar busca no Active Directory");

$info = ldap_get_entries($connect, $busca);



//Salva todos os usuarios em um vetor
 foreach ($info as $Key => $Value )
  {
   $Name      = $info[$Key]["displayname"][0];
   $Account   = $info[$Key]["samaccountname"][0];
   $State     = $info[$Key]["useraccountcontrol"][0];
   $Mail      = $info[$Key]["proxyaddresses"][0];
   $org       = $info[$Key]["distinguishedname"][0];
 
   $State     = dechex($State);
   $State         = substr($State,-1,1);//verifica contas desabilitadas

   $Value = $Name."^".$Account."^".$State."^".$Mail."^".$org;

   if ( $Name != "" && $State != 2)
    $USERs[]=$Value;
  }
 if ( count($USERs) > 0 )
  sort($USERs);

 if ( count($USERs) == 0 )
  {
        echo "Não foi econtrado nenhum usuário";
  }

  //Verifica todos departamentos na OU como financeiro, RH, TI...
 for ($i=0;$i<=count($USERs)-1;$i++)
  {
   $Value    = $USERs[$i];
   $Splitted = explode("^",$Value);

   $Name         = $Splitted[0];
   $Account      = $Splitted[1];
   $State        = $Splitted[2];
   $Mail         = $Splitted[3];
   $org                  = $Splitted[4];

   $org_array = explode(",",$org);
   $org = substr($org_array[2],3,(strlen($org_array[2])));
   $temp[$i] = $org;
 
   $org2 = array_unique($temp);

//Lista os usuarios por departamento
        foreach( $org2 as $mostra ){
                echo"<br>".$mostra;
                 for ($i=0;$i<=count($USERs)-1;$i++)
                  {
                   $Value    = $USERs[$i];
                   $Splitted = explode("^",$Value);

                   $Name         = $Splitted[0];
                   $Account      = $Splitted[1];
                   $State        = $Splitted[2];
                   $Mail         = $Splitted[3];
                        $org            = $Splitted[4];
                                                $org_array = explode(",",$org);
                   $org = substr($org_array[2],3,(strlen($org_array[2])));
                   $temp[$i] = $org;
                   if ($org == $mostra)
                        echo "<br>--".$Name.'--'.$Account.'--'.$Mail;
                }
        }
 }
?> 