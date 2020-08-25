<?php
session_start();


//$manutencao = "disabled";

include_once('classconexao.php');
include_once('classemail.php');
include_once('classdebate.php');

$dd = new sistemaDebate();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Debate de Teses - Cadastro</title>
        <meta name="description" content="description">
        <meta name="author" content="Evgeniya">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
        <!--<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">-->
        <!--<link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>-->
        <link href="css/style.css" rel="stylesheet">
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
        <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->        

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                        <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
                        <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container-fluid">
            <div id="page-login" class="row">
                <div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div class="text-right">
                        <a href="index.php" class="txt-default">
                            <?php
                            if ($_GET["idRegistro"] == 1) {
                                echo "Já possuo registro.";
                            }

                            if ($_GET["idRegistro"] == 2) {
                                echo "Voltar a Página Inicial.";
                            }
                            ?>
                        </a>
                    </div>
                    <div class="box">

                        <?php
                        if ($_GET["idRegistro"] == 1) {
                            include_once 'views/formRegistro.php';
                        }

                        if ($_GET["idRegistro"] == 2) {
                            include_once 'views/formRecuperaSenha.php';
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
