<?php
$dd = new sistemaDebate();
$idgrupo = $_GET['idgrupo'];
//Recuperar dados do Grupo de debate selecionado , informado por GET
//$dd->recuperarGrupo($idgrupo);
//Recuperar as paginas de debates individuais 
$debatesIndividuais = $dd->recuperarDebatesPorGrupo($idgrupo);

//print_r($debatesIndividuais); echo "<br>";echo "<br>";echo "<br>";echo ".............<br>";

foreach ($debatesIndividuais as $debate) {

    //$_GET['iddebate'] = 1008;

    $dd->idgrupo = $idgrupo = $_GET['idgrupo'];
    $dd->iddebate = $iddebate = $debate["iddebate"];
    $debateIndividual = $dd->recuperarDebateIndividual($iddebate);
    $dd->recuperarTeses($idgrupo);
    //$dd->perfilMediador = 1;
    ?>

    <h2 class="titulo02"><?php echo $debateIndividual['titulo'] ?></h2>            
    <div class="tabela">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th width="18%"> Teses</th>
                    <th width="10%"> Posicionamento Inicial</th>
                    <th width="19%"> Argumento</th>
                    <th width="17%">Revisão</th>
                    <th width="17%">Réplica</th>
                    <th width="19%"> Posicionamento Final</th>
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
        
        $nomeRevisorOculto1 = "<b><i>" . $dd->revisoes[0]['nomeCompleto'] . "</i></b>";
        $nomeRevisorOculto2 = "<b><i>" . $dd->revisoes[1]['nomeCompleto'] . "</i></b>";
    ?>                 
                    <tr> 
                        <td rowspan="2" scope="row"><?php echo $tese["tese"]; ?></td> 
                        <td rowspan="2"><?php echo $dd->argumentos[0]['posicionamentoinicial']; ?></td> 
                        <td rowspan="2"><?php echo $dd->argumentos[0]['argumento']; ?></td> 
                        <td> <?php echo $revisao1; echo $nomeRevisorOculto1; ?> </td>
                        <td> <?php echo $replica1; ?> </td>
                        <td rowspan="2"><?php echo $dd->posicionamentos[0]['posicionamentofinal']; ?></td> 
                    </tr>
                    <tr>
                        <td> <?php echo $revisao2; echo $nomeRevisorOculto2; ?></td>
                        <td> <?php echo $replica2; ?></td>
                    </tr> 
    <?php } 
    ?>    
            </tbody>
        </table>
    </div>
    <br>
    <?php
    }
    ?>