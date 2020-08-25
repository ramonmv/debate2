<?php 


if ($debateExclusaoConfirmacao) {
    ?>

    <div id="divExclusaoGrupo">
        <div> 
            <p> <img src="img/confirma.png" style="width:48px;height:48px;vertical-align:middle;" border="0" /> O Debate foi excluído com sucesso!!</p>
        </div>
        <br><br><br>
    </div>

    <?php
} else {
    ?>


    <div id="divExclusaoGrupo">
        <div> 
            <p> <img src="img/erro.png" style="width:48px;height:48px;vertical-align:-10%;" border="0" /> Erro: O Debate não foi excluído, tente novamente. <br><br> <em>Caso persista o erro entre em contato com o administrador informando o ocorrido</em> </p>
        </div>
        <br><br><br>
    </div>




<?php } ?>
