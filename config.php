<?php 
//// este arquivo deverá estar dentro da pasta raiz do Debate de Teses : dt
// esse arquivo está sendo incluido em | $host.'/p4a/applications/dt/principal.php | e |$host.'/dt/classdebate.php'| e | $host.'/p4a/p4a.php | ;
// as vars estao sendo setados no inicio d mestodo construtor

//   LOCALHOST ===============================================================================================================
//$hostBD = "localhost"; $userBD = "root"; $senhaBD = "password"; $databaseBD = "debateteses";
$hostBD = "localhost"; $userBD = "root"; $senhaBD = "password"; $databaseBD = "debate";
//$host = "http://192.168.0.102/debatelocal"; 
// $host = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// $diretorio = 'sites/debate';
$diretorio = 'debate';

$host = 'http://' . $_SERVER['SERVER_NAME'].'/'.$diretorio ;



// $host = substr($host, 0,-1);

// die($host);
// $host = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// $host = "http://localhost/debate2";

// echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// echo "<br>";
// echo $_SERVER['REQUEST_URI'];
// echo "<br>";
// echo $_SERVER['HTTP_REFERER']. $_SERVER['REQUEST_URI'];;

// $host = "http://lied.inf.ufes.br/debate2"; 
//   UFES ====================================================================================================================
//$hostBD = "localhost"; $userBD = "debateteses"; $senhaBD = "credine&rosane"; $databaseBD = "debateteses";
//$host = 'http://www.pead.faced.ufrgs.br/sites/cms/debateteses'; 

// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(1);

// $manutencao = true;

// ini_set('display_errors', 0); 
// ini_set('display_startup_errors', 0); 


// // error_reporting(E_ALL & ~E_NOTICE);
// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//
// ini_set('display_errors',);
// ini_set('display_startup_errors',0);
error_reporting(-2);

if(!isset($idpaginaconfig)) { $idpaginaconfig = 0;}

//============================================================================================================================
//============================================================================================================================
// if ((!defined("P4A_DSN")) and ($idpaginaconfig==13)) {define("P4A_DSN", "mysql://$userBD:$senhaBD@$hostBD/$databaseBD"); }
if(is_object($this))
{
	$this->paginaLogin = $host.'/index.php?';
	$this->paginaMenu = $host.'/menu.php?';
	$this->paginaPrincipal = $host."/menu.php?idpagina=8";
	//$this->paginaP4a = $host.'/p4a/applications/dt/index.php?';
	$this->paginaAnterior = $host."/menu.php?"; 
    $this->paginaDebateCompleto = $host."/debateCompleto.php?"; 

	$this->hostBD = $hostBD;
	$this->userBD = $userBD;
	$this->senhaBD = $senhaBD;
	$this->databaseBD = $databaseBD;
} ?>
