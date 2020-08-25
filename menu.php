<?php
// ------------------------------------ DEBATE NOVO | ACESSO
session_start();

include_once('classemail.php');
include_once('classconexao.php');

include_once('classdebate.php');
include_once('funcoes/funcoes.php');
include_once('interface.php');


// print_r($_SERVER);
// die("<br>....");

// print_r($_SERVER);
// die("<br>....");



$dd = new sistemaDebate();
$dd->paginaAtual = $dd->paginaMenu;

//se logon ... $_SESSION['logon']=true;
//senao: redireciona para o index
$dd->verificaLogon();
$login = $_SESSION['login'];
$senha = $_SESSION['senha'];

//print_r($_POST);
//print_r($_GET);
//print_r($_SESSION);

/*
 *  analisa e executa ações solicitadas a esta página menu
 *  Deve ocorrer esta analise no inicio do script devido a atualização dos dados apresentados
 */
if (isset($_GET['idAcao'])) {
    $dd->idgrupo = $_GET['idgrupo']; // requisito para analisar ação
    $dd->analisarAcao($_GET['idAcao']);
}

//print_r($_POST);
//print_r($_GET);
//print_r($_SESSION);

$dd->recuperarDebatesPorLogin($login, $senha);
$dd->recuperarUsuarios($login, $senha);
$meusGruposComoMediador = $dd->recuperarGruposPorLogin($login, $senha); //grupos recuperados por mediador
$meusGruposComoParticipante = $dd->recuperarGruposParticipantes($login, $senha);

if( (isset($_GET["idgrupo"])) && (!$dd->verificarPertenceColecaoGrupos($meusGruposComoMediador, $meusGruposComoParticipante, $_GET['idgrupo'])) ) {
    $_GET['idpagina'] = 98;
    $idpagina = $_GET['idpagina'];
}

if (isset($_GET['iddebate'])) {
    $dd->iddebate = $_GET['iddebate'];
}
if (isset($_GET['idgrupo'])) {
    $dd->idgrupo = $_GET['idgrupo'];
    $dd->recuperarCronogramaPorGrupo($_GET['idgrupo']); //conograma   
    $dd->recuperarGrupo($_GET['idgrupo']); // atributo do tipo array da classe atualizado com os dados do Grupo corrente
//$dd->recuperarDebatesPorLogin($login, $senha, $idgrupo);    
}

if (isset($_GET['idpagina'])) {
    $idpagina = $_GET['idpagina'];
} else {
    //$idpagina = 7; // id padrao para apresentar a pagina Menu inicial.     
}
if (isset($_GET['idusuarioLog'])) {
    $idusuarioLog = $_GET['idusuarioLog'];
} else {
    $idusuarioLog = null;
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
        <script type="text/javascript" src="plugins/tinymce4/js/tinymce/tinymce.min.js"></script>
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
                        <?php // include_once 'views/bemvindoIndex.php';  ?>
                        <?php // include_once 'views/indexFormLogin.php'; ?>
                    </div> 
                    <?php //                     var_dump($_POST);                      ?>
                    <div id="conteudo" >
                        <div id="divOcilacaoIBOV">

                            <?php
                            if ($idpagina == 1) {
                                apresentaTabelaCronogramaGrupo($dd);
                                apresentaTabelaMeusDebatesIndividuais($dd, $login, $senha);
                            } elseif ($idpagina == 5) { //form de perfil
                                apresentaMeusDados($dd, $login, $senha);
                            } elseif ($idpagina == 6) { //form de perfil
                                apresentaMeusDados($dd, $login, $senha);
                            } elseif ($idpagina == 9) { //ecxlusao de um grupo debate
                                apresentaExclusaoDebateGrupo($dd, $login, $senha);
                            } elseif ($idpagina == 8) { //pagina principal                                                       
                                apresentaTabelaPrincipal($dd, $login, $senha);  //pagina principal
                            } elseif ($idpagina == 10) {

                                $sucesso = $dd->excluirDebateGrupo($dd->idgrupo);
                                apresentaExclusaoConfirmacao($dd, $login, $senha, $sucesso);
                            } elseif ($idpagina == 11) { //menu meus debates - como mediador
                                apresentaTabelaMeusDebatesGrupos($dd, $login, $senha);
                            } elseif ($idpagina == 12) { //menu meus debates - como participante
                                apresentaTabelaMeusDebatesGruposComoParticipante($dd, $login, $senha);
                            } elseif ($idpagina == 14) { //menu meus debates - como participante
                                apresentaTabelaDebateCompleto($dd, $login, $senha);
                            } elseif ($idpagina == 98) { //menu meus debates - como participante
                                apresentaAcessoNegadoGrupo($dd);

                            } elseif ($idpagina == 99) { //menu meus debates - como participante
                                apresentaTabelaMeusDebatesGrupos($dd, $login, $senha);
                                apresentaTabelaMeusDebatesGruposComoParticipante($dd, $login, $senha);
                            } else {

                                if ($idpagina == 2) {
                                    apresentaPaginaConvite($dd);
                                    //   apresentaFormConvite($dd, $link);
                                }

                                if ($idpagina == 4) {
                                    apresentaPaginaCadastroDebateGrupo($dd);
                                }

                                if ($idpagina == 7) {
                                    apresentaPaginaCadastroTese($dd);
                                }
                                if ($idpagina == 13) {
                                    apresentaFormCadastroCronograma($dd);
                                }
                                apresentaTabelaMeusDebatesGrupos($dd, $login, $senha);
                                apresentaTabelaMeusDebatesGruposComoParticipante($dd, $login, $senha);

                                if ($idpagina == 3) {
                                    apresentaPaginaLog($dd, $dd->idgrupo, $idusuarioLog);
                                }
                            }
                            ?>            
                        </div>

                    </div>
                </div>
                <!--End Content-->
            </div>
        </div>

        <?php apresentaNotificacao(); ?>

    </script>
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
