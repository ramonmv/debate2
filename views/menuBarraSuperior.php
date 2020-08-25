<?php

// == 0 se forem iguais
$paginaMenu = strcmp($dd->paginaAtual, $dd->paginaMenu);


if($paginaMenu == 0){
    $link1 = array("idpagina" => 99);     
    $label1 = "Meus debates" ;    
}
if(isset($_GET["idgrupo"])){
    $grupo = $dd->recuperarGrupo($_GET["idgrupo"]);
    $link2 = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 1);
    $label2 = $grupo["titulo" ];

}


?>

<div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <ol class="breadcrumb">
            <li><a href="index.php">Principal</a></li>
            <?php if($paginaMenu == 0 ){  ?> <li><?php  echo $dd->imprime($label1, null, $link1, $dd->paginaMenu, 1, null); ?>  </li>     <?php } ?>       
            <?php if(isset($_GET["idgrupo"])){  ?> <li><?php  echo $dd->imprime($label2, null, $link2, $dd->paginaMenu, 1, null); ?>  </li>     <?php } ?>     
            <?php if($_GET["idpagina"]==15){  ?> <li><?php  echo $dd->imprime("Parceiros", null, Array("idpagina" => 15), $dd->paginaLogin, 1, null); ?>  </li>     <?php } ?>    
        </ol>
    </div>
</div>