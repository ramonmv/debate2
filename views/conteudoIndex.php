<?php
$idpagina = $_GET["idpagina"];

//$dd->recuperarGrupos();

if ($idpagina == 14) { //debate completo
    apresentaTabelaDebateCompleto($dd, $login, $senha);
} 
elseif ($idpagina == 15) { //parceiros
        apresentaParceiros();
} else {

    apresentaTabelaRelacaoDebateGrupo($dd);
}
?>