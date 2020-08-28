

<?php
$dd = new sistemaDebate();
$idgrupo = $_GET['idgrupo'];
$dd->recuperarGrupo($idgrupo);
$criador = $dd->recuperarUsuario(null, $dd->grupo["idusuario"]);
$debatesIndividuais = $dd->recuperarDebatesPorGrupo($idgrupo);
$debatesIndividuais = $dd->filtrarDebatesAtivos($debatesIndividuais, 1);
// $debatesIndividuais = $dd->removerPaginaMediador($debatesIndividuais,$criador['idusuario']); //remoçao ocorre pelo id do usuario criador do grupo
//print_r($debatesIndividuais);
//print_r($dd->grupo);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-content">
                                <p class="page-header">Esta página possui a relação de todas as páginas de debates dos argumentadores </p>
                                <h3><code>Grupo de Debate</code></h3>
                                <p>                                      
                                <pre>Título: <strong> <?php echo $dd->grupo["titulo"]; ?></strong><br/>Criado em: <?php echo $dd->grupo["dataini_br"]; ?><br/>Período: <?php echo $dd->grupo["dataini_br"] . " - " . $dd->grupo["datafim_br"] ?> <br/>Mediador: <?php echo $criador["nomeCompleto"]; ?> <br/>N&ordm; Participantes: <?php echo count($debatesIndividuais) . " participantes"; ?>
                                </pre>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-content">

                                <h3><code>Participantes</code></h3>
                                <p>
                                <pre><?php
                                    foreach ($debatesIndividuais as $debate) {
                                        $titulo = $debate["titulo"];
                                        $iddebate = $debate["iddebate"];
                                        echo "<a href='#' class='part' id='$iddebate' > $titulo </a>";
                                        echo "<br/>";
                                    }
                                    ?></pre>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
if ($dd->grupo["publico"] == 1) {
    foreach ($debatesIndividuais as $debate) {

        if ($debate["ativo"] == 0) {
            continue; // faz pular o debate onde não está ativo , geralmente o debate padrão do mediador
        }

        //$_GET['iddebate'] = 1008;

        $dd->idgrupo = $idgrupo = $_GET['idgrupo'];
        $dd->iddebate = $iddebate = $debate["iddebate"];
        $debateIndividual = $dd->recuperarDebateIndividual($iddebate);
        $dd->recuperarTeses($idgrupo);
        $mediador = $dd->recuperarMediadores($iddebate);
        $argumentador = $dd->recuperarArgumentadores($iddebate);
        $revisor = $dd->recuperarRevisores($iddebate);

        //$dd->perfilMediador = 1;
        ?>
        <!-- o X no título do debate representa o identificador para que seja realizado o indice e ponteiro do scrooll a ser encontrado-->
        <div class="well" id="<?php echo "x" . $debate['iddebate']; ?>">
            <h3 id="grid-options" ><?php echo $debateIndividual['titulo'] ?> </h3>
            <hr>
            <dl class="dl-horizontal">
                <dt><kbd>Argumentador</kbd> </dt>
                <dd> <?php echo $argumentador[0]['primeironome'] . " " . $argumentador[0]['sobrenome']; ?> </dd>

                <dt><kbd>Mediador</kbd> </dt>
                <dd> <?php echo $mediador[0]['primeironome'] . " " . $mediador[0]['sobrenome']; ?>  <br/> </dd> 

                <dt>    <kbd>Revisores</kbd>  </dt>
                <dd> 
                    <?php
                    if (($dd->grupo["blind"] == 2)) {
                        $textoRevisores = $revisor[0]['primeironome'] . " " . $revisor[0]['sobrenome'] . " , " . $revisor[1]['primeironome'] . " " . $revisor[1]['sobrenome'];
                        if (trim(strlen($textoRevisores)) > 6) {
                            echo $textoRevisores;
                            // var_dump($textoRevisores);
                        } else {
                            echo "Os revisores ainda não foram atribuídos.";
                        }
                    } else {
                        echo "<i>As identidades dos revisores estão ocultas</i>";
                    }
                    ?> 
                    <br/>
                </dd>
            </dl>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> Teses</th>
                            <th> Posicionamento Inicial</th>
                            <th> Argumento</th>
                            <th>Revisão</th>
                            <th>Réplica</th>
                            <th> Posicionamento Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dd->teses as $tese) {

                            //reset array de replicas para cada tese
                            $dd->replicas = null;
                            $dd->recuperarArgumentos($tese["idtese"], $dd->iddebate);
                            $dd->recuperarPosicionamentos($tese["idtese"], $dd->iddebate);
                            $dd->recuperaRevisoes($dd->argumentos[0]['idargumento']);
                            $dd->recuperaReplicas($dd->argumentos[0]['idargumentador'], $dd->revisoes[0]['idrevisao']);
                            $dd->recuperaReplicas($dd->argumentos[0]['idargumentador'], $dd->revisoes[1]['idrevisao']);

                            $revisao1 = $dd->revisoes[0]['revisao'];
                            $replica1 = $dd->replicas[0]['replica'];
                            $revisao2 = $dd->revisoes[1]['revisao'];
                            $replica2 = $dd->replicas[1]['replica'];

                            $link[0] = array("iddebate" => $dd->iddebate,
                                "idgrupo" => $dd->idgrupo,
                                "idusuario" => $dd->idusuario,
                                "perfilArgumentador" => $dd->perfilArgumentador,
                                "perfilMediador" => $dd->perfilMediador,
                                "perfilRevisor" => $dd->perfilRevisor,
                                "idargumentador" => $dd->idargumentador,
                                "idmediador" => $dd->idmediador,
                                "idrevisor" => $dd->idrevisor,
                                "idrevisao" => $dd->revisoes[0]['idrevisao'],
                                "idargumento" => $dd->argumentos[0]['idargumento'],
                                "idtese" => $tese["idtese"],
                                "login" => $_GET["login"],
                                "senha" => $_GET["senha"],
                                "admin" => 0
                            );

                            $link[1] = array("iddebate" => $dd->iddebate,
                                "idgrupo" => $dd->idgrupo,
                                "idusuario" => $dd->idusuario,
                                "perfilArgumentador" => $dd->perfilArgumentador,
                                "perfilMediador" => $dd->perfilMediador,
                                "perfilRevisor" => $dd->perfilRevisor,
                                "idargumentador" => $dd->idargumentador,
                                "idmediador" => $dd->idmediador,
                                "idrevisor" => $dd->idrevisor,
                                "idrevisao" => $dd->revisoes[1]['idrevisao'],
                                "idargumento" => $dd->argumentos[0]['idargumento'],
                                "idtese" => $tese["idtese"],
                                "login" => $_GET["login"],
                                "senha" => $_GET["senha"]
                            );

                            if ($verdade) {
                                $classEstilo = "spec";
                                $classEstilo2 = "";
                            } else {
                                $classEstilo = "specalt";
                                $classEstilo2 = "alt";
                            }
                            $verdade = !$verdade;

                            //Apenas poderá ver os nomes dos revisores se aopção blind estiver como negativo =2
                            if ($dd->grupo["blind"] == 2 ) {
                                $nomeRevisorOculto1 = "<b><i>" . $dd->revisoes[0]['nomeCompleto'] . "</i></b>";
                                $nomeRevisorOculto2 = "<b><i>" . $dd->revisoes[1]['nomeCompleto'] . "</i></b>";
                            }
//                           revisores sempre visiveis
//                            $nomeRevisorOculto1 = "<b><i>" . $dd->revisoes[0]['nomeCompleto'] . "</i></b>";
//                            $nomeRevisorOculto2 = "<b><i>" . $dd->revisoes[1]['nomeCompleto'] . "</i></b>";
                            ?>                 
                            <tr> 
                                <td rowspan="2" scope="row"><?php echo $tese["tese"]; ?></td> 
                                <td rowspan="2"><?php echo $dd->argumentos[0]['posicionamentoinicial']; ?></td> 
                                <td rowspan="2"><?php echo $dd->argumentos[0]['argumento']; ?></td> 
                                <td> <?php
                                    echo $revisao1;
                                    echo $nomeRevisorOculto1;
                                    ?> </td>
                                <td> <?php echo $replica1; ?> </td>
                                <td rowspan="2"><?php echo $dd->posicionamentos[0]['posicionamentofinal']; ?></td> 
                            </tr>
                            <tr>
                                <td> <?php
                                    echo $revisao2;
                                    echo $nomeRevisorOculto2;
                                    ?></td>
                                <td> <?php echo $replica2; ?></td>
                            </tr> 
                        <?php } ?>    
                    </tbody>
                </table>
            </div>
        </div>

        <?php
    }
}
?>   
<script type='text/javascript'>

    //jQuery('html, body').animate({scrollTop: jQuery('#teste').offset().top}, 'slow');

    $('.part').click(function () {
        var iddebate = "x" + this.id;
        // $('html, body').animate({scrollTop: $('#caixa').attr('id').offset().top}, 2000);
        jQuery('html, body').animate({scrollTop: (jQuery('#' + iddebate).offset().top) - 50}, 'slow');
    });
</script>