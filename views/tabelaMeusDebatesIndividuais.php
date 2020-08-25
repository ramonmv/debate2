<?php
//se caso for individual aparece apenas a páginda de debate do escolhido, senão apresenta todos
//sera usado este link no cabeçalho do debate
$meusDebateIndividuais = $dd->filtrarDebatesParticipantesPorGrupo($dd->debates, $dd->idgrupo);
//print_r($meusDebateIndividuais);
$souMediadorAlgumDebate = $dd->verificarMediadorColecaoDebate($login, $senha, $meusDebateIndividuais);
//
// var_dump($meusDebateIndividuais);

//echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
//var_dump($dd->idgrupo);
?>

<div class="col-xs-22 col-sm-15 tabelaIndividual">
    <div class="box">     
        <div class="box-header">            
            <div class="box-name">
                <i class="fa fa-table"></i>
                Meus Debates-Individuais
            </div>
            <div class="box-icons">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="expand-link">
                    <i class="fa fa-expand"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="no-move"></div>
        </div>
        <div class="box-content">
            <p></p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="20%"> Debates</th>
                        <?php if (($souMediadorAlgumDebate == 1)) { ?>        <th align="center" width="20%"> Cronograma Individual</th>      <?php }// verifica se o usuário é me3diador em alguma debate individual, se caso sim , cria uma coluna na tabela para que possa colocar o link do cronograma     ?>
                        <th align="center" width="12%"> Meu Perfil</th>
                        <th align="center" width="49%"> Revisores <?php abilitaDelegarTodosRevisores($debate['iddebate'], $dd, $param); ?></th>                  
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $debateIndividual = true;
//  $link = array("idgrupo" => $grupo['idgrupo'], "login" => $login, "senha" => $senha, "idpagina" => 1, "grupo_titulo" => $grupo['titulo']);



                    foreach ($meusDebateIndividuais as $debate) {
                        
                        if($debate["idmediador"] == $debate["idargumentador"]){ 
                            continue; // faz pular o debate onde o argumentador é o mediador de sua própria página 
                        }
                        
                        $link = array("iddebate" => $debate['iddebate'], "idgrupo" => $debate['idgrupo'], "debateIndividual" => $individual, "idpagina" => 8);
                        $dd->verificarPerfil($login, $senha, $debate['iddebate']);
                        $revisor = $dd->recuperarRevisores($debate['iddebate']);
                        ?>                 
                        <tr>
                            <td><?php echo $dd->imprime($debate["titulo"], null, $link, $dd->paginaMenu, 1); ?> </td>
                            <?php if (($dd->perfilMediador === 1)) { ?>       <td><img src="img/page_16.png"  border="0" align="absbottom" /> <?php abilitaCronograma($debate['iddebate'], $dd, $link); ?></td>  <?php } ?>
                            <td><span><?php echo $dd->getNomePerfil(); ?> </span></td>
                            <td>
                                <span>
                                    <?php
                                    if (($dd->grupo["blind"] == 2) || ($dd->perfilMediador === 1)) {
                                        echo $dd->imprime($revisor[0]["primeironome"] . " " . $revisor[0]["sobrenome"], null, $link, $dd->paginaLogin, 0, "indefinido") . " e " . $dd->imprime($revisor[1]["primeironome"] . " " . $revisor[1]["sobrenome"], null, $link, $dd->paginaIndex, 0, "indefinido");  //abilitaDelegarRevisor($debate['iddebate'], $dd, $link);   
                                    } else {
                                        echo "<i>As identidades dos revisores estão ocultas</i>";
                                    }
                                    if ($dd->perfilMediador) {
                                        $dd->listBoxRevisor($debate['idgrupo'], $debate['iddebate'], "revisor1", 1, 1002);
                                        $dd->listBoxRevisor($debate['idgrupo'], $debate['iddebate'], "revisor2", 1, 1002);
                                    }
                                    ?>
                                </span>

                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>