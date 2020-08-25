<?php
//session_start(); 
include_once('classconexao.php');
include_once('classdebate.php');

$dd = new sistemaDebate();
$idgrupo = $_GET['idgrupo'];
//Recuperar dados do Grupo de debate selecionado , informado por GET
$dd->recuperarGrupo($idgrupo);
//Recuperar as paginas de debates individuais 
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
      <title>Debate de Teses | UFRGS/PEAD</title>
      <meta name="keywords" content="ufgrs, ramon maia, dabate de teses" />
      <meta name="description" content="debate de teses, pead, ufrgs, lied." />
      <script language="JavaScript1.2" type="text/javascript">
                var gstrCA = new String('') 
      </script>
      <link rel="stylesheet" href="main.css" />
      <style type="text/css">
      <!--
        .style2 {color: #4175A4}
        .style3 {color: #9EABB6}
      -->
      </style>
      <link rel="stylesheet" href="main.css" type="text/css" />
</head>
<body onload="configuraPainel(0, 1100,'','divLapelaMaioresOcilacoes','P'); TrocarLapela('divLapelaMaioresOcilacoes');MostrarPainel('divMaiorOcilacao')">
<div id="estruturaPrincipal">
  <!-- TOPO -->
  	<div id="topoSimples">
		<!-- LOGO BOVESPA -->
		<h1 class="logoBmfBovespaSimples">	<a  href="<?php echo $dd->paginaLogin;  ?>"></a>		</h1>
		<div class="acessosTopoSimples">
			<span><a id="ctl00_ucTopo_linkDireita" href="http://ufrgs.br">UFRGS/PEAD</a></span>		
                </div>
	</div>
  <div id="estruturaConteudo">
      
<?php    include_once("debatelayout.php"); ?>    
    <div id="divPainel">
        <div class="divConteudo">
          <div id="divMOscilacaoPosicao">
            <?php    include "views/debateIndividualPrincipal.php";    ?>            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
