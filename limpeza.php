<html>    
  <head>

      <style type="text/css">

        tr:nth-child(even) td {
        background: #ffc;
        }
        tr:nth-child(odd) td {
        background: #eee; /* Linhas com fundo cinza */
        }
        BODY{
        font-family: Calibri;
        } 
      </style>
    </head>
    <body TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0>
    
        <center><table>
<?php 
  include "config.php";
  $AD_dados = "";

function Pesquisa_LDAP_all($ID, $nome, $OU, $ID_Banco) {
  $ldapuser = 'rede\usr_smdu_Freenas'; 
  $ldappass = 'Hta123P@';
  $ldaptree    = "OU=Users,OU=".$OU.",DC=rede,DC=sp";



  $ldapconn = ldap_connect('ldap://C65V242I.rede.sp') or die("Não foi conectado ao Servidor ".$ldap_server);

  if($ldapconn) {
        // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldapuser, $ldappass) or die ("Erro ao conectar o servidor ".$ldap_server.": ".ldap_error($ldapconn));

        // verify binding
    if ($ldapbind) {

      $filter = "(&(objectClass=user)(objectCategory=person)(|(samaccountname=$ID))(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";

      $result = ldap_search($ldapconn,$ldaptree, $filter) or die ("Error in search query: ".ldap_error($ldapconn));
      $data = ldap_get_entries($ldapconn, $result);

      for ($i=0; $i<$data["count"]; $i++) {
        if (isset($data[$i]['description'][0]) || (!$data[$i]['description'][0] == "") || (!$data[$i]['description'][0] == NULL) ) {
            $GLOBALS['$AD_dados'] = $data[$i]['description'][0];
          }
      }
  


    } else {
      echo "Consulta LDAP falha...";
    }


  }

    // all done? clean up
  ldap_close($ldapconn);

}


if(isset($_GET['excluir'])) {

      $limpar = $_GET['excluir'];
         
      $sql = mysql_query("DELETE FROM tbl_telefones WHERE id_key = '$limpar'");
      if ($sql) {
        echo "Excluido $limpar\n";
    } else {
        echo "Error dropping database: " . mysql_error() . "\n";
    }
}


  $busca = mysql_query("SELECT * FROM tbl_telefones ORDER BY cp_nome ASC "); 

$todos = array();
$idarray = "0";
      if (mysql_num_rows($busca)>0) {
        while ($dados = mysql_fetch_array($busca)) {

          Pesquisa_LDAP_all($dados['cp_usuario_rede'], $dados['cp_nome'],"SMDU",$dados['id_key']);
          Pesquisa_LDAP_all($dados['cp_usuario_rede'], $dados['cp_nome'],"SEL",$dados['id_key']);
          Pesquisa_LDAP_all($dados['cp_usuario_rede'], $dados['cp_nome'],"SPURBANISMO",$dados['id_key']);
          Pesquisa_LDAP_all($dados['cp_usuario_rede'], $dados['cp_nome'],"ILUME",$dados['id_key']);


            if (!$GLOBALS['$AD_dados'] == ""){
              //echo $GLOBALS['$AD_dados'];
              $GLOBALS['$AD_dados'] = "";
            }else{
              $idarray = $idarray + "1";

                $todos += [$idarray => $dados['id_key']];
                  echo "<tr>";
                  echo "<td>".$dados['cp_usuario_rede']."</td>";
                  echo "<td>".$dados['cp_nome']."</td>";
                  echo "<td>".$dados['cp_cargo']."</td>";
                  echo "<td>".$dados['cp_departamento']."</td>";

                  if(isset($_GET['tudo'])) {

                  $ID = $dados['id_key'];

                  $sql = mysql_query("DELETE FROM tbl_telefones where id_key = $ID");

                    if ($sql) {
                        echo "<td>Excluido</td>";
                    } else {
                        echo "Error dropping database: " . mysql_error() . "\n";
                    }


                  }else{
                    echo "<td><a href='limpeza.php?excluir=".$dados['id_key']."'><center><b>EXCLUIR</b></center></a></td>";
                  }

                  echo "</tr>";
            }
      }
    }

echo "</table>";

echo "<a href='limpeza.php?tudo'><center><b>EXCLUIR TODOS</b></center></a>"; 
          mysql_close($db);


 
