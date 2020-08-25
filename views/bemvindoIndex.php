<?php
if ($_SESSION["logon"] != 1) {
    ?>

    <div class="col-xs-10 col-md-9">

        <h3>Bem vindo, Visitante! </h3>
        <a href="registro.php?idRegistro=1" class="ajax-link" style="font-size:small">  <i class="fa fa-book" > Registre-se</i> </a> | 
        <a href="registro.php?idRegistro=2" class="ajax-link" style="font-size:small">  <i class="fa fa-book" > Recupere sua senha.</i> </a>

    </div>

    <?php
}
?>