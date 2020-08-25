<?php 

$dd = new sistemaDebate();
$grupo = $dd->recuperarGrupo($_GET["idgrupo"]);

?>

<div class="col-xs-12 col-sm-12">
    <div class="box">  
        <div class="box-content">
            <p> <i class="fa fa-exclamation-triangle" style="color: #800"></i> Você tentou acesso ao <strong> Grupo de Debate - <?php echo $grupo["titulo"]; ?></strong>, porém no momento você não participa deste grupo.</p>
        </div>

    </div>
</div>





