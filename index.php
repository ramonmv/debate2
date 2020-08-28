<?php
session_start();

// echo $_SERVER['REQUEST_URI'];
// echo $_SERVER['PHP_SELF'] ;
// echo "<br>";
// echo $_SERVER['SCRIPT_NAME'];
// echo "<br>";
// echo "<br>";
// echo "<br>";

// print_r($dirname ) ;

// echo "aaaa";?
 // die($nnn);


//$manutencao = "disabled";
// $manutencao = true;
// ini_set('display_errors', 1); 
// ini_set('display_startup_errors', 1); 
// error_reporting(E_ALL);

include_once('classconexao.php');
include_once('classemail.php');
include_once('classdebate.php');
include_once('funcoes/funcoes.php');

// $manutencao = true;
// ini_set('display_errors', 1); 
// ini_set('display_startup_errors', 1); 
// error_reporting(E_ALL);

//print_r($_SESSION);
$dd = new sistemaDebate();

if (isset($_GET['idAcao'])) {
    $dd->analisarAcao($_GET['idAcao']);
}

//se caso for envio de um novo registro , pelo formulario de registre-se, não verificar o logon para evitar erros na mensagens de confirmação de cadastro ou erro de email existente
if (!($_GET['formAcao'] == 2) && ($_GET['idAcao'] == 10)) {
//$dd->paginaAtual = $dd->paginaLogin;   verificar a necessidade
    if ($dd->verificaLogon(FALSE)) {
        $login = $_SESSION['login'];
        $senha = $_SESSION['senha'];

        $dd->recuperarDebatesPorLogin($login, $senha);
        $dd->recuperarUsuarios($login, $senha);
        $dd->recuperarGruposPorLogin($login, $senha); //grupos recuperados por mediador
        $dd->recuperarGruposParticipantes($login, $senha);
    }
}
if (isset($_GET['idgrupo'])) {
    $dd->recuperarDebates($_GET['idgrupo']);
    $grupo_titulo = $_GET['grupo_titulo'];
    $dd->recuperarGrupo($_GET['idgrupo']);
    $dd->recuperarCronogramaPorGrupo($_GET['idgrupo']);
    $linkDebateCompleto = array("idgrupo" => $_GET['idgrupo'], "grupo_titulo" => $grupo_titulo);
} else {
    //caso nao tenha enviado o idgrupo CHAMA A ROTINA para recueprar todos grupos ativos
    // idgrupo é enviado (GET) quando clica do em uma opcao na relacao de grupos listado no index mesmo. quando visualizado na primeira vez
    $dd->recuperarGrupos();
}

if (isset($_GET['formAcao'])) {
    $formAcao = $_GET['formAcao'];
} 
else {

    $formAcao = 1;
}

if ( ($_GET['formAcao'] == 4) ) {

    recuperarSenha($_POST['email'] , $dd); 

}





?>



<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Debate de Teses</title>
        <meta name="description" content="description">
        <meta name="author" content="DevOOPS">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
        <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">       
        <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
        <link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
        <link href="plugins/xcharts/xcharts.min.css" rel="stylesheet">
        <link href="plugins/select2/select2.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    </head>

    <body>



        <!--Start Header-->
        <?php include_once 'views/cabecalhoEstrutura.php'; ?>
        <header class="navbar">
            <?php include_once 'views/cabecalhoIndex.php'; ?>
        </header>
        <!--End Header-->
        <!--Start Container-->

        <div id="main" class="container-fluid">
            <div class="row">
                <div id="sidebar-left" class="col-xs-2 col-sm-2">
                    <?php include_once 'views/menuLateralIndex.php'; ?>
                </div>
                <!--Start Content-->
                <div id="content" class="col-xs-12 col-sm-10">
                    <?php include_once 'views/menuBarraSuperior.php'; ?>
                    <div id="dashboard-header" class="row">
                        <?php include_once 'views/bemvindoIndex.php'; ?>
                        <?php
                        if (!$dd->verificaLogon()) {
                            include_once 'views/indexFormLogin.php';
                        }
                        ?>
                    </div>  

                    <?php //                     var_dump($_POST);                        ?>

                    <div id="conteudo" >
                        <!--                        <div class="alert alert-warning alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <strong>Warning!</strong> Better check yourself, you're not looking too good.
                                                </div>-->
                        <?php include_once 'views/conteudoIndex.php'; ?>

                    </div>


                </div>
                <!--End Content-->
            
            </div>
            
        </div>

        

        <?php     

        apresentaNotificacao(); 

        ?>
        <!--End Container-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <!--<script src="http://code.jquery.com/jquery.js"></script>-->
        <script src="plugins/jquery/jquery-2.1.0.min.js"></script>
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="plugins/bootstrap/bootstrap.min.js"></script>
        <script src="plugins/justified-gallery/jquery.justifiedgallery.min.js"></script>
        <!--<script src="plugins/tinymce/tinymce.min.js"></script>-->
        <!--<script src="plugins/tinymce/jquery.tinymce.min.js"></script>-->
        <!-- All functions for this theme + document.ready processing -->
        <script src="js/devoops.js"></script>

    </body>
</html>
