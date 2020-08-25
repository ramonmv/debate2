<?php
$verdade = true;
$nomeRevisorOculto1 = "";
$nomeRevisorOculto2 = "";
//-----------------------------
$dd = new sistemaDebate();

$dd->idgrupo = $idgrupo = $_GET['idgrupo'];
$dd->iddebate = $iddebate = $_GET['iddebate'];
$login = $_SESSION['login'];
$senha = $_SESSION['senha'];

//recupera dados de um determinado debate. Retorna um array com os indices (campos)
$debateIndividual = $dd->recuperarDebateIndividual($iddebate);

//atualizando variavel que indica a pagina corrente para poder utilizar o `metodo voltar`
$dd->paginaAtual = $dd->paginaPrincipal;

//verifica se foi logado
$dd->verificaLogon();
$dd->recuperarUsuarios($login, $senha);
$mediador = $dd->recuperarMediadores($iddebate);

$argumentador = $dd->recuperarArgumentadores($iddebate);

$revisor = $dd->recuperarRevisores($iddebate);

$dd->recuperarTeses($idgrupo);
$dd->recuperarCronograma($iddebate, $idgrupo, null);
$dd->verificarPerfil($login, $senha, $iddebate);

//print_r($argumentador);
//$senhaCodificada = base64_encode($senha);
//echo base64_decode($senhaCodificada);

if (isset($_GET['idgrupo'])) {
    $dd->idgrupo = $_GET['idgrupo'];
    $dd->recuperarCronogramaPorGrupo($idgrupo); //conograma
    $dd->recuperarGrupo($idgrupo); // atributo do tipo array da classe atualizado com os dados do Grupo corrente
    //$dd->recuperarDebatesPorLogin($login, $senha, $idgrupo);
}

?>
<div class="well">

    <h3 id="grid-options"><?php echo $debateIndividual['titulo'] ?> </h3>
    <hr>
    <dl class="dl-horizontal">
        <dt><kbd>Argumentador</kbd> </dt>
        <dd> <?php echo $argumentador[0]['primeironome'] . " " . $argumentador[0]['sobrenome']; ?> </dd>

        <dt><kbd>Mediador</kbd> </dt>
        <dd> <?php echo $mediador[0]['primeironome'] . " " . $mediador[0]['sobrenome'] . "<br/>"; ?> </dd>

        <dt>    <kbd>Revisores</kbd>  </dt>
        <dd> 
            <?php
            if (($dd->grupo["blind"] == 2) || ($dd->perfilMediador === 1)) {
                echo $revisor[0]['primeironome'] . " " . $revisor[0]['sobrenome'] . " , " . $revisor[1]['primeironome'] . " " . $revisor[1]['sobrenome'] . "<br/>";
            } else {
                echo "<i>As identidades dos revisores estão ocultas</i>";
            }
            ?> 
        </dd>
    </dl>
    <hr>

    <form method="post" action="#" id="form1" style="display: none;">
        <textarea id="editor" style="width:100%" name="editor"> Edite aqui... </textarea>
        <button id="link4">Confirmar Atualização</button>
    </form>
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
                        "admin" => 0,
                        "revisaoMask" => FALSE
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
                        "senha" => $_GET["senha"],
                        "revisaoMask" => TRUE
                    );
                    if ($verdade) {
                        $classEstilo = "spec";
                        $classEstilo2 = "";
                    } else {
                        $classEstilo = "specalt";
                        $classEstilo2 = "alt";
                    }
                    $verdade = !$verdade;

                    //Apenas o mediador poderá ver os nomes dos revisores na página de debate de teses
                    if (($dd->perfilMediador === 1) || ($dd->grupo["blind"] == 2 )) {
                        $nomeRevisorOculto1 = "<b><i>" . $dd->revisoes[0]['nomeCompleto'] . "</i></b>";
                        $nomeRevisorOculto2 = "<b><i>" . $dd->revisoes[1]['nomeCompleto'] . "</i></b>";
                    }
                    ?>                 
                    <tr> 
                        <td rowspan="2" scope="row"><?php echo $dd->imprime($tese["tese"], 0, $link[0], $dd->paginaPrincpal); ?></td> 
                        <td rowspan="2"><?php $link[0]["idAcao"]=2001; echo $dd->imprime($dd->argumentos[0]['posicionamentoinicial'], "argumento", $link[0], $dd->paginaPrincipal, 0, "indefinido"); ?></td>
                        <td rowspan="2"><?php $link[0]["idAcao"]=2002; echo $dd->imprime($dd->argumentos[0]['argumento'], "argumento", $link[0], $dd->paginaPrincipal); ?></td> 
                        <td> <?php
                            $link[0]["idAcao"]=2003;  
                            echo $dd->imprime($revisao1, "revisao", $link[0], $dd->paginaPrincipal);
                            echo $nomeRevisorOculto1;
                            ?> </td>
                        <td> <?php $link[0]["idAcao"]=2004; echo $dd->imprime($replica1, "replica", $link[0], $dd->paginaPrincipal); ?> </td>
                        <td rowspan="2"><?php $link[0]["idAcao"]=2005;  echo $dd->imprime($dd->posicionamentos[0]['posicionamentofinal'], "posicionamento", $link[0], $dd->paginaPrincipal); ?></td> 
                    </tr>
                    <tr>
                        <td> <?php
                            $link[1]["idAcao"]=2003;
                            echo $dd->imprime($revisao2, "revisao", $link[1], $dd->paginaPrincipal);
                            echo $nomeRevisorOculto2;
                            ?></td>
                        <td> <?php $link[1]["idAcao"]=2004; echo $dd->imprime($replica2, "replica", $link[1], $dd->paginaPrincipal); ?></td>
                    </tr> 
                <?php } ?>    
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        menubar: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic forecolor backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media preview | emoticons",
        image_advtab: true,
        templates: [
            //   {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ]
    });

    $(document).ready(function () {
        $(".chamaForm").click(function () {
            document.getElementById('form1').action = this.href;
              tinymce.activeEditor.setContent(this.text);
            this.href = "#"; //
            $("form").show(1000);


        });

    });

    function cal(tex) {

        //    alert(tex);
    }

//    $(document).ready(function () {
//        $("#hide").click(function () {
//            $("p").hide(1000);
//        });
//        $("#show").click(function () {
//            $("p").show(1000);
//        });
//    });
</script>