<?php

$linkExclusaoSim = array("idgrupo" => $dd->grupo["idgrupo"] ,"login" => $login, "senha" => $senha, "idpagina" => 10 );
$linkExclusaoNao = array("login" => $login, "senha" => $senha );

?>
<div id="divExclusaoGrupo">
    <div> 
        <p> <img src="img/iconDelete.jpg" style="width:62px;height:55px;vertical-align:middle;" border="0" />Tem certeza que deseja excluir o Debate: <b> <?php echo $dd->grupo['titulo']; ?> ? </b></p>
        <div class="linkDestaque"><p style="text-indent:65px;"><?php echo $dd->imprime("<b>Sim</b>, eu quero confirmar a exclusão do debate.", null, $linkExclusaoSim, $dd->paginaMenu, 1); ?></p></div>
        <p style="text-indent:65px;"><?php echo $dd->imprime("<b>Não</b>, eu quero cancelar a exclusão e voltar aos \"Meus Debates\" sem excluí-lo.", null, $linkExclusaoNao, $dd->paginaMenu, 1); ?></p>
    </div>
    
    
    
    <br><br><br><br>
    <p style="font-size: 10pt"> <b>Atenção:</b> Ao excluir o debate, todas as páginas individuais do debate serão excluídas, assim como todas as teses, argumentações e revisões. Não será possível desfazer esta operação.</p>
</div>